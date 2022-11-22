<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailerInterface): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contact = $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to("fred@frederic-caffier.fr")
                ->subject('contact sur le site Tv_Show')
                ->htmlTemplate('contact/email.html.twig')
                ->context([
                    'object' => $contact->get('object')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            // Envoie du mail
            $mailerInterface->send($email);

            // Confirmation d'envoi + message de confirmation
            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render(
            'contact/contact.html.twig',
            [
                'form' => $contactForm->createView(),
            ]
        );
    }
}