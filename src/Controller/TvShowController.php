<?php

namespace App\Controller;

use App\Entity\TvShow;
use App\Form\TvShowType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tv_show')]
class TvShowController extends AbstractController
{
    #[Route('/list', name: 'tv_show_list', methods: 'GET')]
    public function list(Request $request, PaginatorInterface $paginator): Response
    {
        $search = $request->query->get('search');

        /** @var TvShowRepository $repository */
        $repository = $this->getDoctrine()->getRepository(TvShow::class);
        // $tvShows = $repository->findAll();
        // $tvShows = $repository->findAllVisibleQuery($search);

        $tvShows = $paginator
            ->paginate($repository->findAllVisibleQuery($search),
               $request->query->getInt('page', 1),
               12    
            );



        return $this->render('tv_show/list.html.twig',
            [
                'tvShows' => $tvShows
            ]
        );
    }

    // Autres syntaxe pour requierements
    // #[Route('/blog/{page<\d+>}', name: 'blog_list')]
    #[Route('/{id}/{slug}', name: 'tv_show_view', requirements: ['id' => '\d+'], methods: 'GET')]
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
