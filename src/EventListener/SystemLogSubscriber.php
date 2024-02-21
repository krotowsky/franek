<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\SystemLog;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\SystemLogEvent;
use Doctrine\ORM\EntityManagerInterface;

class SystemLogSubscriber implements EventSubscriberInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public static function getSubscribedEvents(): array
    {
        return [
            SystemLogEvent::NAME => 'onSystemLogEvent',
        ];
    }

    public function onSystemLogEvent(SystemLogEvent $event): void
    {
        $logEntry = new SystemLog();
        $logEntry->setMessage($event->getMessage());
        $logEntry->setCreatedAt(new \DateTime('now'));
        $this->entityManager->persist($logEntry);
        $this->entityManager->flush();
    }
}
