<?php

namespace App\Controller;

use App\Entity\TvShow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TvShowController extends AbstractController
{
    #[Route('/tvShows', name: 'tv_show_list')]
    public function list(): Response
    {
        return $this->render('tv_show/list.html.twig');
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
