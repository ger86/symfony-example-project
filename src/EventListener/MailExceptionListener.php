<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class MailExceptionListener
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('New exception with code: ' . $exception->getCode())
            ->text($exception->getMessage());

        $this->mailer->send($email);
    }
}
