<?php

namespace App\Service\Article;

use App\Entity\Article;
use App\Entity\Category;
use App\Event\Article\ArticleCreated;
use App\Model\Article\ErrorCreatingArticle;
use App\Repository\ArticleRepository;
use App\Service\EventDispatcherInterface;
use DateTimeImmutable;
use Exception;
use Throwable;

class CreateArticle
{
    public function __construct(
        private ArticleRepository $articleRepository,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function __invoke(
        string $title,
        string $body,
        string $author,
        DateTimeImmutable $createdAt,
        bool $isPublished,
        ?Category $category,
        ?string $image
    ): Article {
        $article = new Article(
            $title,
            $body,
            $author,
            $createdAt,
            $isPublished,
            $category,
            $image
        );
        try {
            $this->articleRepository->save($article);
        } catch (Throwable $e) {
            throw new ErrorCreatingArticle($e->getMessage());
        }
        $this->eventDispatcher->dispatch(new ArticleCreated($article->getId()));
        return $article;
    }
}
