<?php

namespace App\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(private SymfonyEventDispatcherInterface $eventDispatcher)
    {
    }

    public function dispatch(object $event, ?string $eventName = null): object
    {
        return $this->eventDispatcher->dispatch($event, $eventName);
    }
}
