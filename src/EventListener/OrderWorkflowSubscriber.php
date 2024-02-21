<?php

declare(strict_types=1);
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class OrderWorkflowSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.order_workflow.transition.notify' => 'onOrderNotify',
        ];
    }

    public function onOrderNotify(Event $event): void
    {
        $order = $event->getSubject();
        // Logic to notify the review maker
    }
}
