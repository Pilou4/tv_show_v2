<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonController extends AbstractController
{
    #[Route("/person/{id}", name: 'person_view', requirements: ['id' => '\d+'])]
    public function view($id): Response
    {
        /** @var PersonRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Person::class);
        // $category = $repository->findOneWithTvShows($id);
        $person = $repository->find($id);
        
        return $this->render(
            'person/view.html.twig',
            [
                "person" => $person
        ]);
    }

    #[Route('person/add', name: 'person_add')]
    public function add(Request $request){
        $person = new Person();

        $personForm = $this->createForm(PersonType::class, $person);
        $personForm->handleRequest($request);

        if($personForm->isSubmitted() && $personForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($person);
            $manager->flush();

            $this->addFlash("success", "La personne a bien été ajoutée");
            return $this->redirectToRoute("tv_show_admin_list");

        }
        return $this->render(
            'person/add.html.twig',
            [
                "personForm" => $personForm->createView()
            ]
        );
    }

    #[Route('person/{id}/update', name: 'person_update', requirements: ['id' => '\d+'])]
    public function update(Request $request, Person $person){

        $personForm = $this->createForm(PersonType::class, $person);
        $personForm->handleRequest($request);

        if($personForm->isSubmitted() && $personForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($person);
            $manager->flush();

            $this->addFlash("success", "La personne a bien été modifié");
            return $this->redirectToRoute("tv_show_admin_list");

        }
        return $this->render(
            'person/update.html.twig',
            [
                "personForm" => $personForm->createView(),
                "person" => $person
            ]
        );
    }

    #[Route('/person/{id}/delete', name: 'person_delete', requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Person $person)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($person);
        $manager->flush();
        $this->addFlash("success", "La personne a bien été supprimé");
        return $this->redirectToRoute("tv_show_admin_list");
    }
}
