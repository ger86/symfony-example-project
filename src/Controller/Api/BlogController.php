<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Form\Model\ArticleModel;
use App\Form\Type\ArticleFormType;
use App\Model\Article\ArticleNotFound;
use App\Repository\ArticleRepository;
use App\Service\Article\CreateArticle;
use App\Service\Article\DeleteArticle;
use App\Service\Article\GetAllArticles;
use App\Service\MailerInterface;
use DateTimeImmutable;
use Exception;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\{Delete, Get, Post, Put};

class BlogController extends AbstractRestController
{
    #[Get(path: '/api/articles')]
    public function list(GetAllArticles $getAllArticles): View
    {
        $articles = ($getAllArticles)();
        return $this->createView($articles, []);
    }

    #[Get(path: '/api/articles/{id}')]
    public function single(string $id, ArticleRepository $articleRepository): View
    {
        throw new Exception();
        $article = $articleRepository->find($id);
        if ($article === null) {
            throw new ArticleNotFound($id);
        }
        return $this->createView($article, ['article']);
    }

    #[Post(path: '/api/articles')]
    public function post(CreateArticle $createArticle, Request $request): View
    {
        $model = new ArticleModel();
        $form = $this->createForm(ArticleFormType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = ($createArticle)(
                $model->title,
                $model->body,
                '',
                new DateTimeImmutable(),
                true,
                $model->category,
                null
            );
            return $this->createView($article, ['article'], Response::HTTP_CREATED);
        }
        return $this->createView($form, [], Response::HTTP_BAD_REQUEST);
    }

    #[Put(path: '/api/articles/{id}')]
    public function put(string $id, ArticleRepository $articleRepository, Request $request): View
    {
        $article = $articleRepository->find($id);
        if ($article === null) {
            throw new ArticleNotFound($id);
        }
        $model = new ArticleModel(
            $article->getTitle(),
            $article->getBody(),
            $article->getIsPublished(),
            $article->getCategory(),
            true
        );
        $form = $this->createForm(ArticleFormType::class, $model);

        $json = json_decode($request->getContent(), true);
        $form->submit($json, false);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->update(
                $model->title,
                $model->body,
                $model->isPublished,
                $model->category
            );
            $articleRepository->save($article);
            return $this->createView($article, ['article'], Response::HTTP_CREATED);
        }
        return $this->createView($form, [], Response::HTTP_BAD_REQUEST);
    }

    #[Delete(path: '/api/articles/{id}')]
    public function delete(string $id, DeleteArticle $deleteArticle): View
    {
        ($deleteArticle)($id);
        return $this->createView(null, [], Response::HTTP_NO_CONTENT);
    }
}
