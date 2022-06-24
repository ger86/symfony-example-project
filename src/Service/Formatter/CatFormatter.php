<?php

namespace App\Service\Formatter;

class CatFormatter implements Formatter
{
    public function format(string $text): string
    {
        return $text . "CAT";
    }
}
