<?php

namespace App\Service\Article;

use App\Entity\Article;
use App\Model\Article\ArticleNotFound;
use App\Repository\ArticleRepository;

class FindArticle
{

    public function __construct(private ArticleRepository $articleRepository)
    {
    }

    public function __invoke(int $id): Article
    {
        $article = $this->articleRepository->find($id);
        if ($article === null) {
            throw new ArticleNotFound($id);
        }
        return $article;
    }
}
