<?php

namespace App\EventSubscriber\Article;

use App\Event\Article\ArticleCreated;
use App\Service\Article\FindArticle;
use App\Service\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Throwable;

class SendEmailOnArticleCreated implements EventSubscriberInterface
{
    public function __construct(private MailerInterface $mailer, private FindArticle $findArticle)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            ArticleCreated::class => 'onArticleCreated'
        ];
    }

    public function onArticleCreated(ArticleCreated $event)
    {
        try {
            $article = ($this->findArticle)($event->articleId);
            $this->mailer->send(
                'admin@latteandcode.com',
                'Artículo creado',
                'email/article_created.html.twig',
                [
                    'article' => $article
                ]
            );
        } catch (Throwable) {
        }
    }
}
