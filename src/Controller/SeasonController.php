<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\TvShow;
use App\Form\SeasonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SeasonController extends AbstractController
{
    #[Route('/season/add/{id}', name: 'season_add', requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_ADMIN")]
    public function add(TvShow $tvShow, Request $request)
    {
        $season = new Season();
        // j'initialise ma saison pour qu'elle soit liée à la série dont l'id est dans la route
        $season->setTvShow($tvShow);

        $seasonForm = $this->createForm(SeasonType::class, $season);
        $seasonForm->handleRequest($request);
        if($seasonForm->isSubmitted() && $seasonForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($season);
            $manager->flush();

            $this->addFlash("success", "La saison a bien été ajoutée");
            return $this->redirectToRoute("tv_show_view", ["id" => $tvShow->getId()]);
        }

        return $this->render('season/add.html.twig', [
            "seasonForm" => $seasonForm->createView()
        ]);
    }
}