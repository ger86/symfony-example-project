<?php

namespace App\Service\Formatter;

class UppercaseFormatter implements Formatter
{
    public function format(string $text): string
    {
        return strtoupper($text);
    }

    public static function getDefaultPriority(): int
    {
        return 20;
    }
}
