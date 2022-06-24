<?php

namespace App\Event\Article;

use Symfony\Contracts\EventDispatcher\Event;

class ArticleCreated extends Event
{
    public function __construct(public readonly int $articleId)
    {
    }
}
