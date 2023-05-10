<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    //request contient les demandes du navigateur
    // Mailer interface : machine pour envoyer des emails
    public function index(Request $request, MailerInterface $mailer): Response
    {
        //créer le formulaire selon le ContactType
        $form = $this->createForm(ContactType::class);
        // récupérer les données de la requête du navigateur
        $form->handleRequest($request);

        // si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //récupérer l'email
            $adress = $form->get('email')->getData();
            //récupérer le sujet
            $sujet = $form->get('sujet')->getData();
            //récupérer le message
            $message = $form->get('message')->getData();

            //creation d'un nouvel objet Email
            $email = (new Email())
            // le mail d'où vient la demande de contact
            ->from($adress)
            // envoyé à qui
            ->to('admin@admin.com')
            // le sujet de la demande de contact
            ->subject($sujet)
            //le message de la demande de contact
            ->text($message);

            //envoyer le mail créé précédemment
            $mailer->send($email);

            return $this->redirectToRoute('app_success');

        }
        // renderForm pour afficher un formulaire
        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form
        ]);
    }

    #[Route('/contact/success', name: 'app_success')]
    public function success(): Response
    {
        return $this->render('success/index.html.twig', [
            'controller_name' => 'SuccessController',
        ]);
    }
}
