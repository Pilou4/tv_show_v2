<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Form\EpisodeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EpisodeController extends AbstractController
{
    #[Route('/episode/add/{id}', name: 'episode_add', requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_ADMIN")]
    public function add(Request $request, Season $season)
    {
        $episode = new Episode();
        // j'initialise ma saison pour qu'elle soit liée à la série dont l'id est dans la route
        $episode->setSeason($season);

        $episodeForm = $this->createForm(EpisodeType::class, $episode);
        $episodeForm->handleRequest($request);
        if($episodeForm->isSubmitted() && $episodeForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($episode);
            $manager->flush();

            $this->addFlash("success", "L'épisode a bien été ajoutée");
            return $this->redirectToRoute("tv_show_view", ["id" => $season->getTvShow()->getId()]);
        }

        return $this->render('episode/add.html.twig', [
            "episodeForm" => $episodeForm->createView()
        ]);
    }

    #[Route('/episode/update/{id}', name: 'episode_update', requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_ADMIN")]
    public function update(Episode $episode, Request $request)
    {

        $episodeForm = $this->createForm(EpisodeType::class, $episode);
        $episodeForm->handleRequest($request);
        if($episodeForm->isSubmitted() && $episodeForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash("success", "L'épisode' a bien été ajoutée");
            return $this->redirectToRoute("tv_show_view", ["id" => $episode->getSeason()->getTvShow()->getId()]);
        }

        return $this->render('season/update.html.twig', [
            "episodeForm" => $episodeForm->createView(),
            "episode" => $episode
        ]);
    }

    #[Route('/episode/{id}/delete', name: 'episode_delete', requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Episode $episode)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($episode);
        $manager->flush();
        $this->addFlash("success", "L'épisode a bien été supprimé");
        return $this->redirectToRoute("tv_show_view", ["id" => $episode->getSeason()->getTvShow()->getId()]);
    }

}
