<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Workflow\Registry;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use App\Event\OrderStatusChangedEvent;

class OrderController extends AbstractController
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
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
            $event = new OrderStatusChangedEvent($orderId, $status);
//            $this->eventDispatcher->dispatch($event,'onOrderStatusChanged');
            $this->eventDispatcher->dispatch($event,'onOrderNotify');
        } else {
            $this->addFlash('danger', 'Status not allowed');
        }

        return $this->redirectToRoute('app_index');
    }
}
