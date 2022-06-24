<?php

namespace App\Service\Article;

use App\Repository\ArticleRepository;

class GetAllArticles
{

    public function __construct(private ArticleRepository $articleRepository, private int $appArticlesLimit)
    {
    }

    public function __invoke(): array
    {
        $articles = $this->articleRepository->findBy([], null, $this->appArticlesLimit);
        return $articles;
    }
}
