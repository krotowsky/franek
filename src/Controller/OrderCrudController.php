<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/panel/order')]
class OrderCrudController extends AbstractController
{
    #[Route('/list', name: 'app_order_crud_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        $statuses [] = ['draft', 'pending','declined','accepted'];
        $orders = $orderRepository->findByStatusAndRole($statuses);

        return $this->render('order_crud/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/new', name: 'app_order_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setStatus('draft');
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('app_order_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order_crud/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_crud_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order_crud/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_order_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order_crud/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_order_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
