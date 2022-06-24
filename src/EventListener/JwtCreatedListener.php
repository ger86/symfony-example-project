<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

final class JwtCreatedListener
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            return;
        }
        $payload = $event->getData();
        $payload['ip'] = $request->getClientIp();
        $event->setData($payload);
    }
}
