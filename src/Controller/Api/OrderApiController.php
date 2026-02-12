<?php

namespace App\Controller\Api;

use App\Application\Factory\OrderFactory;
use App\Dto\OrderCreateDto;
use App\Dto\OrderUpdateDto;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/orders', name: 'api_orders_')]
class OrderApiController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private OrderRepository $orderRepository,
        private ValidatorInterface $validator
    ) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $filters = [
            'customerCode' => $request->query->get('customerCode'),
            'customerName' => $request->query->get('customerName'),
            'orderNumber' => $request->query->get('orderNumber'),
            'dateFrom' => $request->query->get('dateFrom'),
            'dateTo' => $request->query->get('dateTo'),
        ];

        $orders = $this->orderRepository->findByFilters($filters);

        return $this->json([
            'success' => true,
            'data' => array_map(fn ($order) => $this->serializeOrder($order), $orders)
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        if (! $order) {
            return $this->json([
                'success' => false,
                'message' => 'Order not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'success' => true,
            'data' => $this->serializeOrder($order),
        ]);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] 
        OrderCreateDto $dto,
        OrderFactory $orderFactory,
    ): JsonResponse {

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage().", prop. path: ".$error->getPropertyPath();
            }
            return $this->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errorMessages
            ], Response::HTTP_BAD_REQUEST);
        }

        // foreach ($dto->orderProducts as $i => $p) {
        //     dump($i, gettype($p), $p);
        // }
        // die;

        $order = $orderFactory->createFromDto($dto);

        $this->orderRepository->save($order, true);

        return $this->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $this->serializeOrder($order)
        ], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        int $id,
        #[MapRequestPayload] OrderUpdateDto $dto,
        OrderFactory $orderFactory,
    ): JsonResponse {
        $order = $this->orderRepository->find($id);

        // if (!$order) {
        //     return $this->json([
        //         'success' => false,
        //         'message' => 'Order not found'
        //     ], Response::HTTP_NOT_FOUND);
        // }

        // $data = json_decode($request->getContent(), true);

        // if (!$data) {
        //     return $this->json([
        //         'success' => false,
        //         'message' => 'Invalid JSON data'
        //     ], Response::HTTP_BAD_REQUEST);
        // }

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage() . ", prop. path: " . $error->getPropertyPath();
            }
            return $this->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errorMessages
            ], Response::HTTP_BAD_REQUEST);
        }

        // foreach ($dto->orderProducts as $i => $p) {
        //     dump($i, gettype($p), $p);
        // }
        // die;

        //  dd($dto);

        $order = $orderFactory->updateFromDto($order, $dto);

        // dd($order);


        // if (isset($data['orderNumber'])) {
        //     $order->setOrderNumber($data['orderNumber']);
        // }
        // if (isset($data['customerCode'])) {
        //     $order->setCustomerCode($data['customerCode']);
        // }
        // if (isset($data['customerName'])) {
        //     $order->setCustomerName($data['customerName']);
        // }

        // if (isset($data['products']) && is_array($data['products'])) {
        //     // Remove existing products
        //     foreach ($order->getOrderProducts() as $product) {
        //         $order->removeOrderProduct($product);
        //     }

        //     // Add new products
        //     foreach ($data['products'] as $productData) {
        //         $orderProduct = new OrderProduct();
        //         $orderProduct->setProductCode($productData['productCode'] ?? '');
        //         $orderProduct->setProductName($productData['productName'] ?? '');
        //         $orderProduct->setPrice($productData['price'] ?? '0');
        //         $orderProduct->setQuantity($productData['quantity'] ?? 0);
        //         $order->addOrderProduct($orderProduct);
        //     }
        // }

        $errors = $this->validator->validate($order);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errorMessages
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $this->serializeOrder($order)
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return $this->json([
                'success' => false,
                'message' => 'Order not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->orderRepository->remove($order, true);

        return $this->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);
    }

    private function serializeOrder(Order $order): array
    {
        return [
            'id' => $order->getId(),
            'orderNumber' => $order->getOrderNumber(),
            'customerCode' => $order->getCustomerCode(),
            'customerName' => $order->getCustomerName(),
            'createdAt' => $order->getCreatedAt()->format('Y-m-d H:i:s'),
            'totalAmount' => $order->getTotalAmount(),
            'products' => array_map(function ($product) {
                return [
                    'id' => $product->getId(),
                    'productCode' => $product->getProductCode(),
                    'productName' => $product->getProductName(),
                    'price' => $product->getPrice(),
                    'quantity' => $product->getQuantity(),
                    'subtotal' => $product->getSubtotal(),
                ];
            }, $order->getOrderProducts()->toArray())
        ];
    }
}
