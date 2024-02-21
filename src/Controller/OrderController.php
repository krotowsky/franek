<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Workflow\Registry;

class OrderController extends AbstractController
{
    #[Route('/order/{status}/{orderId}', name: 'app_order_accept',methods: ['GET'])]
    public function acceptOrder(int $orderId,string $status, Registry $workflows, EntityManagerInterface $entityManager): Response
    {

        $order = $entityManager->getRepository(Order::class)->find($orderId);

        if (!$order) {
            throw $this->createNotFoundException('Order not found.');
        }

        $workflow = $workflows->get($order, 'order_workflow');

        if ($workflow->can($order, $status)) {
            $workflow->apply($order, $status);
            $entityManager->flush();
            $this->addFlash('success', 'Order has been updated');
            // Additional logic (e.g., notify review maker)
        } else {
            $this->addFlash('danger', 'Status not allowed');
        }

        return $this->redirectToRoute('app_index');
    }
}
