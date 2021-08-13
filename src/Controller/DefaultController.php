<?php

namespace App\Controller;

use App\Service\WelcomeMessageGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function __construct(private WelcomeMessageGenerator $welcomeMessageGenerator)
    {   
    }

    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
       // recupérer depuis le WelcomeMessageGenerator un message de bienvenue aléatoire

        // on peut recupérer un service directement depuis le container
        // $generator = $this->container->get(WelcomeMessageGenerator::class);

        $welcomeMessage = $this->welcomeMessageGenerator->getRandomMessage();

        return $this->render(
            'default/homepage.html.twig',
            [
                "welcomeMessage" => $welcomeMessage
            ]
        );
    }
}
