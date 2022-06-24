<?php

namespace App\Event\User;

use Symfony\Contracts\EventDispatcher\Event;

class UserCreated extends Event
{
    public function __construct(public readonly int $userId)
    {
    }
}
