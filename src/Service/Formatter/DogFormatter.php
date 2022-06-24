<?php

namespace App\Service\Formatter;

class DogFormatter implements Formatter
{
    public function format(string $text): string
    {
        return "DOG" . $text;
    }
}
