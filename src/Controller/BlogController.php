<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\Model\ArticleModel;
use App\Form\Type\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Service\Article\GetAllArticles;
use DateTimeImmutable;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route(path: '/articles', name: 'articles', methods: ['GET'])]
    public function list(GetAllArticles $getAllArticles): Response
    {
        $articles = ($getAllArticles)();
        return $this->render('views/articles_list.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route(path: '/articles/{id}', name: 'article_detail')]
    public function detail(string $id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);
        if ($article === null) {
            throw $this->createNotFoundException('Artículo no encontrado');
        }
        return new Response($article->getTitle());
    }

    #[Route(path: '/articles/{id}/edit', name: 'article_edit')]
    public function edit(string $id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);
        if ($article === null) {
            throw $this->createNotFoundException('Artículo no encontrado');
        }
        $article->setTitle(sprintf('Title: %d', time()));
        $articleRepository->save($article);

        return new Response($article->getTitle());
    }

    #[Route(path: '/articles/{id}/delete', name: 'article_delete')]
    public function delete(string $id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);
        if ($article === null) {
            throw $this->createNotFoundException('Artículo no encontrado');
        }
        $articleRepository->delete($article);

        return $this->redirectToRoute('articles');
    }

    #[Route(path: '/article-create', name: 'article_create')]
    public function create(Request $request, ArticleRepository $articleRepository): Response
    {
        $model = new ArticleModel();
        $form = $this->createForm(ArticleFormType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = new Article(
                $model->title,
                $model->body,
                '',
                new DateTimeImmutable(),
                $model->isPublished,
                null,
                $model->category
            );
            $articleRepository->save($article);
            return $this->redirectToRoute('articles');
        }

        return $this->renderForm('views/create_article.html.twig', [
            'articleForm' => $form
        ]);
    }

    #[Route(path: '/article-bulk-create', name: 'article_bulk_create')]
    public function bulkCreate(ArticleRepository $articleRepository, Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find(1);
        $count = $request->get('count', 2);
        for ($i = 0; $i < $count; $i++) {
            $article = new Article(
                'Title',
                'Body',
                'Author',
                new DateTimeImmutable(),
                true,
                $category,
                null
            );
            $articleRepository->save($article, $i === $count - 1);
        }

        return $this->redirectToRoute('articles');
    }
}
