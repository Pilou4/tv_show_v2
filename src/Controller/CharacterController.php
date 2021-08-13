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

             // je recupère le fichier uploadé
            /** @var UploadedFile $pictureFile */
            $pictureFile = $characterForm->get('picture')->getData();
            // si un fichier a ,bien été uploadé (optionnel)
            if ($pictureFile) {
                // je genere un nom de fichier aléatoire pour éviter que deux fichiers ai le meme nom et s'écrasent 
                // $pictureFilename = 6515611321561.jpg
                $pictureFilename = uniqid() . "." . $pictureFile->guessExtension();
                // je deplace le fichier (qui à été mis dans un dossier temporaire par PHP)
                // je le met dans mon dossier public avec le nom que je vient de generer
                $pictureFile->move(
                    $this->getParameter('picture_directory'),
                    $pictureFilename
                );
                // je met sur l'entité (pour enregistrer en BDD) le nom du fichier qui vient d'etre mis dans le dossier public
                $character->setPictureFilename($pictureFilename);
            }

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


            // je recupère le fichier uploadé
            /** @var UploadedFile $pictureFile */
            $pictureFile = $characterForm->get('picture')->getData();
            // si un fichier a ,bien été uploadé (optionnel)
            if ($pictureFile) {
                // je genere un nom de fichier aléatoire pour éviter que deux fichiers ai le meme nom et s'écrasent 
                // $pictureFilename = 6515611321561.jpg
                $pictureFilename = uniqid() . "." . $pictureFile->guessExtension();
                // je deplace le fichier (qui à été mis dans un dossier temporaire par PHP)
                // je le met dans mon dossier public avec le nom que je vient de generer
                $pictureFile->move(
                    $this->getParameter('picture_directory'),
                    $pictureFilename
                );
                // je met sur l'entité (pour enregistrer en BDD) le nom du fichier qui vient d'etre mis dans le dossier public
                $character->setPictureFilename($pictureFilename);
            }

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