<?php

namespace App\Controller;

use App\Entity\TvShow;
use App\Form\TvShowType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TvShowController extends AbstractController
{
    #[Route('/tv-shows', name: 'tv_show_list')]
    public function list(Request $request): Response
    {
        $search = $request->query->get('search');

        /** @var TvShowRepository $repository */
        $repository = $this->getDoctrine()->getRepository(TvShow::class);
        // $tvShows = $repository->findAll();
        $tvShows = $repository->findByTitle($search);


        return $this->render('tv_show/list.html.twig',
            [
                'tvShows' => $tvShows
            ]
        );
    }

    // Autres syntaxe pour requierements
    // #[Route('/blog/{page<\d+>}', name: 'blog_list')]
    #[Route('/tv-show/{id}', name: 'tv_show_view', requirements: ['id' => '\d+'])]
    public function view($id): Response
    {
         /** @var TvShowRepository $repository */
         $repository = $this->getDoctrine()->getRepository(TvShow::class);
         $tvShow = $repository->findWithCollections($id);

        return $this->render('tv_show/view.html.twig',
            [
                "tvShow" => $tvShow
            ]
        );
    }

    #[Route('/tv-show/add', name: 'tv_show_add')]
    public function add(Request $request)
    {
        // je crée un objet
        $tvShow = new TvShow();
        // je demande a créer un formulaire grace à ma classe de formulaire
        // et je fourni a mon nouveau formulaire l'objet qu'il doit manipuler
        $form = $this->createForm(TvShowType::class, $tvShow);
        // je demande au formulaire de recupérer les données dans la request
        $form->handleRequest($request);
        // automatiquement le formulaire a mis a jour mon objet $tvShow
        // Si des données ont été soumises dans le formulaire
        if($form->isSubmitted() && $form->isValid()) {
            // si je souhaite ajouter cette entité en base de donnée j'ai besoin du manager
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tvShow);
            $manager->flush();
            $this->addFlash("success", "La série a bien été ajoutée");
            return $this->redirectToRoute('tv_show_list');
        }
        // on envoi une representation simplifiée du formulaire dans la template
        return $this->render(
            'tv_show/add.html.twig',
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
            'tv_show/update.html.twig',
            [
                "tvShowForm" => $form->createView(),
                "tvShow" => $tvShow
            ]
        );
    }

    #[Route('/tv-show/{id}/delete', name: 'tv_show_delete', requirements: ['id' => '\d+'])]
    public function delete(TvShow $tvShow)
    {
        // 1 - on recupère l'entité à supprimer (param converter / repository)
        // Nous on l'a fait avec le param converter

        // 2 - on recupère le manager
        $manager = $this->getDoctrine()->getManager();

        // 3 - on demande au manager de supprimer l'entité
        $manager->remove($tvShow);
        $manager->flush();

        // 4 - on met un message pour dire que ca s'est bien passé
        $this->addFlash("success", "La série a bien été supprimée");

        // 5 - on redirige vers une page qui montre l'effet (la liste des series, on va pouvoir voir que la serie n'y est plus)
        return $this->redirectToRoute('tv_show_list');
    }
}
