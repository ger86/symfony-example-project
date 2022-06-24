<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use App\Entity\Category;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{

    public function testConstructor()
    {
        $title = 'título';
        $body = 'body';
        $now = new DateTimeImmutable();

        $category = new Category('name');
        $article = new Article(
            $title,
            $body,
            'author',
            $now,
            true,
            $category,
            'image'
        );

        $this->assertEquals($title, $article->getTitle());
        $this->assertEquals($body, $article->getBody());
    }

    public function testUpdate()
    {
        $title = 'título 2';
        $body = 'body 2';
        $now = new DateTimeImmutable();

        $category = new Category('name');
        $category2 = new Category('name2');
        $article = new Article(
            'título 1',
            'body 1',
            'author',
            $now,
            true,
            $category,
            'image'
        );
        $article->update($title, $body, false, $category2);

        $this->assertEquals($title, $article->getTitle());
        $this->assertEquals($body, $article->getBody());
        $this->assertEquals($category2, $article->getCategory());
    }
}
