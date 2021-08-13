<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class WelcomeMessageGenerator
{

    private $tokenStorage;

    // je demande au container de me transmettre une instance du service TokenStorageInterface
    // ce service me permettra de recupérer l'uitilisateur connecté
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getRandomMessage()
    {
        $anonymousMessages = [
            "Coucou les p'tit loups !",
            "Salut les amis !",
            "Kapoué !!!"
        ];

        $userMessage = [
            "Bienvenue #name !",
            "Hey re-bonjour #name !",
            "Mais c'est #name que revoila !"
        ];

        $message = null;

        // je recupère l'utilisateur connecté grace au tokenStorage
        // $user = $this->tokenStorage->getToken()->getUser();

        // si l'utilisateur n'est pas connecté alors $user contiendra la chaine de caractere "anon."
        // par contre si l'utilisateur est connecté $user contiendra un objet de type App\Entity\User

        // if($user instanceof User) {
        //     // utilisateur connecté, je peux récuperer son username
        //     $message = $userMessage[mt_rand(0, count($userMessage) - 1)];
        //     $message = str_replace("#name", $user->getUsername(), $message);
        // } else {
        //     // utilisateur pas connecté je met un message anonyme 
        //     $message = $anonymousMessages[mt_rand(0, count($anonymousMessages) - 1)];
        // }

        return $message;

    }
} 