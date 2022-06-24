<?php

namespace App\Service\Formatter;

interface Formatter
{
    public function format(string $text): string;
}
