<?php

namespace App\Repository;

use App\Entity\OrderProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderProduct>
 */
class OrderProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderProduct::class);
    }

    public function save(OrderProduct $orderProduct, bool $flush = false): void
    {
        $this->getEntityManager()->persist($orderProduct);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderProduct $orderProduct, bool $flush = false): void
    {
        $this->getEntityManager()->remove($orderProduct);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
