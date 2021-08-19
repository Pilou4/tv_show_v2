<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    #[Route("/category/add", name: 'category_add')]
    #[IsGranted("ROLE_ADMIN")]
    public function add(Request $request)
    {
        $category = new Category();

        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("success", "La catégorie a bien été ajoutée");
            return $this->redirectToRoute('tv_show_admin_list');

        }
        return $this->render(
            'category/add.html.twig',
            [
                "categoryForm" => $categoryForm->createView()
            ]
        );
    }

    #[Route("/category/{id}/update", name: 'category_update', requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_ADMIN")]
    public function update(Request $request, Category $category)
    {
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("success", "La catégorie a bien été modifié");
            return $this->redirectToRoute("tv_show_admin_list");
        }
        return $this->render(
            'category/update.html.twig',
            [
                "categoryForm" => $categoryForm->createView(),
                "category" => $category
            ]
        );
    }

    #[Route('/category/{id}/delete', name: 'category_delete', requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Category $category)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($category);
        $manager->flush();
        $this->addFlash("success", "La catégorie a bien été supprimé");
        return $this->redirectToRoute("tv_show_admin_list");
    }
}