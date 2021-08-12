<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route("/categories", name: 'category_list', requirements: ['id' => '\d+'])]
    public function list(): Response
    {
         /** @var CategoryRepository $repository */
         $repository = $this->getDoctrine()->getRepository(Category::class);
         $categories = $repository->findAllOrderedByLabel();

        return $this->render('category/list.html.twig', ["categories" => $categories]);
    }

    #[Route("/category/{id}", name: 'category_view', requirements: ['id' => '\d+'])]
    public function view($id): Response
    {
        /** @var CategoryRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findOneWithTvShows($id);
        
        return $this->render('category/view.html.twig', ["category" => $category]);
    }
}
