<?php

namespace App\Service;

interface EventDispatcherInterface
{
    public function dispatch(object $event, ?string $eventName = null): object;
}
