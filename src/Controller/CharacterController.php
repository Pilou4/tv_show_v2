<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\TvShow;
use App\Form\CharacterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    #[Route('/character/add/{id}', name: 'character_add', requirements: ['id' => '\d+'])]
    public function add(TvShow $tvShow, Request $request)
    {
        $character = new Character();
        $character->setTvShow($tvShow);

        $characterForm = $this->createForm(CharacterType::class, $character);
        $characterForm->handleRequest($request);
        if($characterForm->isSubmitted() && $characterForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($character);
            $manager->flush();

            $this->addFlash("success", "Le personnage a bien été ajouté");
            return $this->redirectToRoute("tv_show_view", ["id" => $tvShow->getId()]);
        }

        return $this->render(
            'character/add.html.twig',
            [
                "characterForm" => $characterForm->createView()
            ]
        );
    }

    #[Route('/character/{id}/update', name: 'character_update', requirements: ['id' => '\d+'])]
    public function update(Character $character, Request $request)
    {
        $characterForm = $this->createForm(CharacterType::class, $character);
        $characterForm->handleRequest($request);
        if($characterForm->isSubmitted() && $characterForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash("success", "Le personnage a bien été modifié");
            return $this->redirectToRoute("tv_show_view", ["id" => $character->getTvShow()->getId()]);
        }

        return $this->render(
            'character/update.html.twig',
            [
                "characterForm" => $characterForm->createView(),
                "character" => $character
            ]
        );
    }

    #[Route('/character/{id}/delete', name: 'character_delete', requirements: ['id' => '\d+'])]
    public function delete(Character $character)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($character);
        $manager->flush();
        $this->addFlash("success", "Le personnage a bien été supprimé");
        return $this->redirectToRoute("tv_show_view", ["id" => $character->getTvShow()->getId()]);
    }
}