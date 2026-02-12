<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {
    }

    #[Route('/', name: 'app_order_index')]
    public function index(Request $request): Response
    {
        return $this->render('order/index.html.twig');
    }

    #[Route('/order/create', name: 'app_order_create')]
    public function create(): Response
    {
        return $this->render('order/create.html.twig');
    }

    #[Route('/order/{id}', name: 'app_order_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $order = $this->orderRepository->find($id);

        if (! $order) {
            throw $this->createNotFoundException('Order not found');
        }

        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/order/{id}/edit', name: 'app_order_edit', requirements: ['id' => '\d+'])]
    public function edit(int $id): Response
    {
        $order = $this->orderRepository->find($id);

        if (! $order) {
            throw $this->createNotFoundException('Order not found');
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/order/{id}/print', name: 'app_order_print', requirements: ['id' => '\d+'])]
    public function print(int $id): Response
    {
        $order = $this->orderRepository->find($id);

        if (! $order) {
            throw $this->createNotFoundException('Order not found');
        }

        return $this->render('order/print.html.twig', [
            'order' => $order,
        ]);
    }
}
