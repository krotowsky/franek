<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\Order1Type;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile/order')]
class OrderReviewMakerController extends AbstractController
{
    #[Route('/list', name: 'app_order_review_maker_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        $statuses [] = ['draft', 'published'];
        $orders = $orderRepository->findByStatusAndRole($statuses);

        return $this->render('order_review_maker/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/{id}', name: 'app_order_review_maker_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order_review_maker/show.html.twig', [
            'order' => $order,
        ]);
    }
}
