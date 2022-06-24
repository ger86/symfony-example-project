<?php

namespace App\Tests\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleRepositoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [];
        for ($i = 0; $i < 4; $i++) {
            $category = new Category(
                sprintf('name-%d', $i)
            );
            $manager->persist($category);
            $categories[] = $category;
        }


        for ($i = 0; $i < 10; $i++) {
            $article = new Article(
                sprintf('title-%d', $i),
                sprintf('body-%d', $i),
                sprintf('author-%d', $i),
                new DateTimeImmutable(
                    sprintf('-%d days', $i)
                ),
                $i % 2 === 0,
                $categories[$i % 4],
                sprintf('image-%d', $i),
            );
            $manager->persist($article);
        }
        $manager->flush();
    }
}
