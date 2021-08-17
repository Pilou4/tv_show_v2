<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\TvShow;
use App\Entity\Episode;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SeasonController extends AbstractController
{
    #[Route('season/{id}', name: 'season_view', requirements: ['id' => '\d+'])]
    public function view($id): Response
    {
         /** @var SeasonRepository $repository */
         $repository = $this->getDoctrine()->getRepository(Season::class);
         $season = $repository->findAllEpisodesOrderedByNumber($id);

        /** @var EpisodeRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Episode::class);
        $episodes = $repository->findAllOrderedByNumber($id);
 
        return $this->render('season/view.html.twig',
            [
                "season" => $season,
                "episodes" => $episodes
            ]
        );
    }

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

    #[Route('/season/update/{id}', name: 'season_update', requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_ADMIN")]
    public function update(Season $season, Request $request)
    {

        $seasonForm = $this->createForm(SeasonType::class, $season);
        $seasonForm->handleRequest($request);
        if($seasonForm->isSubmitted() && $seasonForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash("success", "La saison a bien été ajoutée");
            return $this->redirectToRoute("tv_show_view", ["id" => $season->getTvShow()->getId()]);
        }

        return $this->render('season/update.html.twig', [
            "seasonForm" => $seasonForm->createView(),
            "season" =>$season
        ]);
    }

    #[Route('/season/{id}/delete', name: 'season_delete', requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Season $season)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($season);
        $manager->flush();
        $this->addFlash("success", "La saison a bien été supprimé");
        return $this->redirectToRoute("tv_show_view", ["id" => $season->getTvShow()->getId()]);
    }
}