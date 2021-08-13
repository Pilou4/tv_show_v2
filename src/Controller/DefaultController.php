<?php

namespace App\Controller;

use App\Service\WelcomeMessageGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DefaultController extends AbstractController
{
    public function __construct(private WelcomeMessageGenerator $welcomeMessageGenerator, private HttpClientInterface $client)
    {   
    }

    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        $welcomeMessage = $this->welcomeMessageGenerator->getRandomMessage();
        // recupérer une joe depuis http://api.icndb.com/jokes/random
        $response = $this->client->request(
            'GET',
            "http://api.icndb.com/jokes/random"
        );
        $content = $response->toArray();
        $joke = $content['value']['joke'];
        
        return $this->render(
            'default/homepage.html.twig',
            [
                "welcomeMessage" => $welcomeMessage,
                "joke" => $joke
            ]
        );
    }
}
