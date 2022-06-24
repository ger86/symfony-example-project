<?php

namespace App\Service;

interface MailerInterface
{
    public function send(string $to, string $subject, string $templatedName, array $vars, ?string $from = null): void;
}
