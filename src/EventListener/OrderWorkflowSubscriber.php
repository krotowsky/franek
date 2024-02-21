<?php

declare(strict_types=1);
namespace App\EventListener;

use App\Entity\SystemLog;
use App\Event\OrderStatusChangedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class OrderWorkflowSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.order_workflow.transition.notify' => 'onOrderNotify',
            'workflow.order_workflow.transition.create' => 'onOrderNotify',
            'workflow.order_workflow.transition.decline' => 'onOrderNotify'
        ];
    }

    /**
     * @param OrderStatusChangedEvent $event
     * @return void
     */
    public function onOrderStatusChanged(OrderStatusChangedEvent $event): void
    {
        $this->systemlog("status updated");
    }

    public function onOrderNotify(Event $event): void
    {
        $order = $event->getSubject();
        $this->systemlog('status updated');
        // Logic to notify the review maker
    }

    public function systemlog(string $log): void{
        $message = new SystemLog();
        $message->setMessage($log);
        $message->setCreatedAt(new \DateTime('now'));
        $this->entityManager->persist($message);
        $this->entityManager->flush();

    }
}
