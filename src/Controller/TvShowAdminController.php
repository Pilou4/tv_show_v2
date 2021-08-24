<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\TvShow;
use App\Entity\Category;
use App\Form\TvShowType;
use App\Service\Uploader;
use App\Repository\PersonRepository;
use App\Repository\CategoryRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class TvShowAdminController extends AbstractController
{
    public function __construct(private Uploader $uploader)
    {
    }
    
    #[Route('tv-show/add', name: 'tv_show_add')]
    public function add(Request $request)
    {
        $tvShow = new TvShow();

        $form = $this->createForm(TvShowType::class, $tvShow);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $tvShow->setCreatedAt(new DateTimeImmutable());
            $tvShow->setUpdatedAt(new DateTimeImmutable());

            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                $pictureFilename = $this->uploader->upload($pictureFile);
                $tvShow->setPictureFile($pictureFilename);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tvShow);
            $manager->flush();
            $this->addFlash("success", "La série a bien été ajoutée");
            return $this->redirectToRoute('tv_show_list');
        }

        return $this->render(
            'admin/tv_show/add.html.twig',
            [
                "tvShowForm" => $form->createView()
            ]
        );
    }

    #[Route('/tv-show/{id}/update', name: 'tv_show_update', requirements: ['id' => '\d+'])]
    public function update(TvShow $tvShow, Request $request)
    {
        $tvShow->setUpdatedAt(new DateTimeImmutable());

        $form = $this->createForm(TvShowType::class, $tvShow);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                $pictureFilename = $this->uploader->upload($pictureFile);
                $tvShow->setPictureFile($pictureFilename);
            }
            
            $manager = $this->getDoctrine()->getManager(); 
            $manager->flush();

            $this->addFlash("success", "La série a bien été mise à jour");
            // je redirige vers la page qui affiche le detail de la series que l'on vient de modifier
            return $this->redirectToRoute('tv_show_view', ["id" => $tvShow->getId()]);
        }

        return $this->render(
            'admin/tv_show/update.html.twig',
            [
                "tvShowForm" => $form->createView(),
                "tvShow" => $tvShow
            ]
        );
    }

    #[Route('/tv-show/{id}/delete', name: 'tv_show_delete', requirements: ['id' => '\d+'])]
    public function delete(TvShow $tvShow)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($tvShow);
        $manager->flush();

        $this->addFlash("success", "La série a bien été supprimée");

        return $this->redirectToRoute('tv_show_list');
    }
}