<?php

namespace App\Controller;

use App\Entity\TvShow;
use App\Form\TvShowType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tv_show')]
class TvShowController extends AbstractController
{
    #[Route('/list', name: 'tv_show_list')]
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
    #[Route('/{id}', name: 'tv_show_view', requirements: ['id' => '\d+'])]
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
}
