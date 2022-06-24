<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\{TwigFilter, TwigFunction};

class BlogExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return [
            new TwigFunction('charCount', [$this, 'charCount'])
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('withHeaderImage', [$this, 'withHeaderImage'], [
                'is_safe' => ['html']
            ]),
        ];
    }

    public function charCount(string $text): int
    {
        return \strlen(strip_tags($text));
    }

    public function withHeaderImage(string $text, int $width): string
    {
        return sprintf('<img src="https://placedog.net/%d"><br>%s', $width, $text);
    }
}
