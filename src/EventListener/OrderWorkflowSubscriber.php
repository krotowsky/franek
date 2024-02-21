<?php

declare(strict_types=1);
namespace App\EventListener;

use App\Entity\SystemLog;
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
            'workflow.order_workflow.transition.decline' => 'onOrderNotify',
            'workflow.order_workflow.transition.revert' => 'onOrderNotify',
        ];
    }


    public function onOrderNotify(Event $event): void
    {
        $orderStatus = json_encode($event->getSubject(),JSON_HEX_QUOT);
//        $this->systemlog("Update: $orderStatus");
    }

    public function systemlog(string $log): void{
        $message = new SystemLog();
        $message->setMessage($log);
        $message->setCreatedAt(new \DateTime('now'));
        $this->entityManager->persist($message);
        $this->entityManager->flush();

    }
}
