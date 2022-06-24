<?php

namespace App\Service\Formatter;

class ThanksFormatter implements Formatter
{
    public function format(string $text): string
    {
        return $text . 'Muchas gracias por participar.';
    }
}
