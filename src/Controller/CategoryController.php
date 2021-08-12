<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route("/category/{id}", name: 'category_view', requirements: ['id' => '\d+'])]
    public function view(Category $category): Response
    {
        return $this->render('category/view.html.twig', ["category" => $category]);
    }
}
