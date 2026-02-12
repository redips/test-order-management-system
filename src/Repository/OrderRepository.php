<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $order, bool $flush = false): void
    {
        $this->getEntityManager()->persist($order);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $order, bool $flush = false): void
    {
        $this->getEntityManager()->remove($order);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Find orders with optional filters.
     *
     * @return Order[]
     */
    public function findByFilters(array $filters = []): array
    {
        $qb = $this->createQueryBuilder('o')
            ->leftJoin('o.orderProducts', 'op')
            ->addSelect('op')
            ->orderBy('o.createdAt', 'DESC');

        if (! empty($filters['customerCode'])) {
            $qb->andWhere('o.customerCode LIKE :customerCode')
               ->setParameter('customerCode', '%'.$filters['customerCode'].'%');
        }

        if (! empty($filters['customerName'])) {
            $qb->andWhere('o.customerName LIKE :customerName')
               ->setParameter('customerName', '%'.$filters['customerName'].'%');
        }

        if (! empty($filters['orderNumber'])) {
            $qb->andWhere('o.orderNumber LIKE :orderNumber')
               ->setParameter('orderNumber', '%'.$filters['orderNumber'].'%');
        }

        if (! empty($filters['dateFrom'])) {
            $qb->andWhere('o.createdAt >= :dateFrom')
               ->setParameter('dateFrom', new \DateTime($filters['dateFrom']));
        }

        if (! empty($filters['dateTo'])) {
            $dateTo = new \DateTime($filters['dateTo']);
            $dateTo->setTime(23, 59, 59);
            $qb->andWhere('o.createdAt <= :dateTo')
               ->setParameter('dateTo', $dateTo);
        }

        return $qb->getQuery()->getResult();
    }

    public function findOneByOrderNumber(string $orderNumber): ?Order
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.orderProducts', 'op')
            ->addSelect('op')
            ->andWhere('o.orderNumber = :orderNumber')
            ->setParameter('orderNumber', $orderNumber)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
