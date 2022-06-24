<?php

namespace App\Tests\Service;

use App\Entity\Article;
use App\Service\Mailer;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MailerIntegrationTest extends KernelTestCase
{
    public function testMailIsSent()
    {
        $container = $this->getContainer();

        /** @var Mailer */
        $mailer = $container->get(Mailer::class);

        $article = new Article('title', 'body', 'author', new DateTimeImmutable(), true, null, null);
        $mailer->send(
            'gerardo@latteandcode.com',
            'Hola',
            'email/article_created.html.twig',
            [
                'article' => $article
            ]
        );

        $this->assertEmailCount(1);
        $email = $this->getMailerMessage();
        $this->assertEmailHtmlBodyContains($email, 'Se ha creado: title');
    }
}
