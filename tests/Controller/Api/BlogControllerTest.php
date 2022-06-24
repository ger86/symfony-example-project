<?php

namespace App\Tests\Controller\Api;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogControllerTest extends WebTestCase
{
    public function testPost()
    {
        $client = self::createClient();
        $client->request(
            Request::METHOD_POST,
            '/api/articles',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                "title" => "Blasssss",
                "body" => "fdsffdfdfdfdfdf",
                "isPublished" => 1
            ])
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());

        $responseContent = $client->getResponse()->getContent();
        $json = json_decode($responseContent, true);

        $this->assertEquals('Blasssss', $json['title']);
        $this->assertEquals('DOGFDSFFDFDFDFDFDFCATMuchas gracias por participar.', $json['body']);
        $this->assertEquals(true, $json['isPublished']);
        $this->assertArrayHasKey('id', $json);
        $this->assertArrayHasKey('createdAt', $json);

        /** @var ArticleRepository */
        $articleRepository = $this->getContainer()->get(ArticleRepository::class);
        $article = $articleRepository->find($json['id']);
        $this->assertNotNull($article);

        $this->assertEmailCount(1);
    }
}
