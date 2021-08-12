<?php

namespace App\Controller;

use App\Entity\TvShow;
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
    public function view(TvShow $tvShow): Response
    {
        return $this->render('tv_show/view.html.twig',
            [
                "tvShow" => $tvShow
            ]
        );
    }

    #[Route('/tv-show/add', name: 'tv_show_add')]
    public function add(): Response
    {
        $tvShow = new TvShow();
        $tvShow->setTitle("The Mandalarian");

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($tvShow);
        $manager->flush();

        return $this->render('tv_show/add.html.twig');
    }
}
