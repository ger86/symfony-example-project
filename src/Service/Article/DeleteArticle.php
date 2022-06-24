<?php

namespace App\Service\Article;

use App\Repository\ArticleRepository;
use App\Security\Voter\ArticleVoter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class DeleteArticle
{
    public function __construct(
        private FindArticle $findArticle,
        private ArticleRepository $articleRepository,
        private Security $security
    ) {
    }

    public function __invoke(int $articleId): void
    {
        $article = ($this->findArticle)($articleId);
        if (!$this->security->isGranted(ArticleVoter::DELETE, $article)) {
            throw new AccessDeniedException();
        }
        $this->articleRepository->delete($article);
    }
}
