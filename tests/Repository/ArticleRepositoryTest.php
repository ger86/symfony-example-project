<?php

namespace App\Tests\Repository;

use App\Repository\ArticleRepository;
use App\Tests\DataFixtures\ArticleRepositoryFixtures;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;


class ArticleRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
        /** @var AbstractDatabaseTool $databaseTool */
        $databaseTool = $this->getContainer()->get(DatabaseToolCollection::class)->get();
        $databaseTool->loadFixtures([ArticleRepositoryFixtures::class])->getReferenceRepository();
    }

    public function testFindAll()
    {
        $container = $this->getContainer();

        /** @var ArticleRepository */
        $articleRepository = $container->get(ArticleRepository::class);

        $this->assertCount(10, $articleRepository->findAll());
    }
}
