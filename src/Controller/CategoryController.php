<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route(path: '/category-create', name: 'category_create', methods: ['GET'])]
    public function create(CategoryRepository $categoryRepository): Response
    {
        $category = new Category(sprintf('Name: %d', time()));
        $categoryRepository->save($category);
        return new Response('Categoría creada');
    }
}
