<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface as SymfonyMailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class Mailer implements MailerInterface
{
    public function __construct(private SymfonyMailerInterface $mailer, private string $defaultEmailFrom)
    {
    }

    public function send(string $to, string $subject, string $templatedName, array $vars, ?string $from = null): void
    {
        $email = (new TemplatedEmail())
            ->from($from ?? $this->defaultEmailFrom)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($templatedName)
            ->context($vars);

        $this->mailer->send($email);
    }
}
