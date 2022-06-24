<?php

namespace App\Service\Formatter;

class ApplyFormatters
{
    /**
     * @var Formatter[]
     */
    private array $formatters = [];

    public function __construct(
        iterable $formatters
    ) {
        $this->formatters = iterator_to_array($formatters);
    }

    public function __invoke(string $text): string
    {
        $formattedText = $text;
        foreach ($this->formatters as $formatter) {
            $formattedText = $formatter->format($formattedText);
        }
        return $formattedText;
    }
}
