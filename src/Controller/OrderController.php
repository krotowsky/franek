<?php

namespace App\Controller;

use App\Entity\Order;
use App\Event\SystemLogEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Workflow\Registry;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class OrderController extends AbstractController
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    #[Route('/order/{status}/{orderId}', name: 'app_order_accept',methods: ['GET'])]
    public function acceptOrder(
        int $orderId,string $status,
        Registry $workflows,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ): Response
    {

        $order = $entityManager->getRepository(Order::class)->find($orderId);

        if (!$order) {
            throw $this->createNotFoundException('Order not found.');
        }

        $workflow = $workflows->get($order, 'order_workflow');

        if ($workflow->can($order, $status)) {
            $workflow->apply($order, $status);
            $entityManager->flush();
            $json = $serializer->serialize(array([
                'userId' => $this->getUser()->getUserIdentifier(),
                'orderId' => $order->getId(),
                'orderStatus' => $order->getStatus(),
                'orderSummary' => $order->getSummary(),
                'orderOwner' => $order->getCustomer()->getEmail()
                ]
            ),'json');

            $this->eventDispatcher->dispatch(new SystemLogEvent($json), SystemLogEvent::NAME);
            $this->addFlash('success', 'Order has been updated');
        } else {
            $this->addFlash('danger', 'Status not allowed');
        }

        return $this->redirectToRoute('app_index');
    }
}
