<?php

namespace App\Controller;

use App\Entity\TvShow;
use App\Form\TvShowType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class TvShowAdminController extends AbstractController
{
    #[Route('/list', name: 'tv_show_admin_list')]
    public function list()
    {
        /** @var TvShowRepository $repository */
        $repository = $this->getDoctrine()->getRepository(TvShow::class);
        $tvShows = $repository->findAll();
        // $tvShows = $repository->findByTitle($search);
        
        return $this->render(
            'admin/list.html.twig',
            [
                "tvShows" => $tvShows,
            ]
        );
    }

    #[Route('tv-show/add', name: 'tv_show_add')]
    public function add(Request $request)
    {
        $tvShow = new TvShow();

        $form = $this->createForm(TvShowType::class, $tvShow);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tvShow);
            $manager->flush();
            $this->addFlash("success", "La série a bien été ajoutée");
            return $this->redirectToRoute('tv_show_list');
        }

        return $this->render(
            'admin/tv_show/add.html.twig',
            [
                "tvShowForm" => $form->createView()
            ]
        );
    }

    #[Route('/tv-show/{id}/update', name: 'tv_show_update', requirements: ['id' => '\d+'])]
    public function update(TvShow $tvShow, Request $request)
    {
        $form = $this->createForm(TvShowType::class, $tvShow);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager(); 
            $manager->flush();

            $this->addFlash("success", "La série a bien été mise à jour");
            // je redirige vers la page qui affiche le detail de la series que l'on vient de modifier
            return $this->redirectToRoute('tv_show_view', ["id" => $tvShow->getId()]);
        }

        return $this->render(
            'admin/tv_show/update.html.twig',
            [
                "tvShowForm" => $form->createView(),
                "tvShow" => $tvShow
            ]
        );
    }

    #[Route('/tv-show/{id}/delete', name: 'tv_show_delete', requirements: ['id' => '\d+'])]
    public function delete(TvShow $tvShow)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($tvShow);
        $manager->flush();

        $this->addFlash("success", "La série a bien été supprimée");

        return $this->redirectToRoute('tv_show_list');
    }
}