<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerService $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $subject = 'Demande de contact sur votre site de la part de ' . $contactFormData['civility'] . $contactFormData['lastname'] . ' ' . $contactFormData['firstname'] . '.';
            $content = $contactFormData['civility'] . ' ' . $contactFormData['lastname'] . ' ' . $contactFormData['firstname'] . ' vous a envoyé le message suivant: ' . '<br><br>"' . $contactFormData['message'] . '"<br><br>' . 'Voici ses coordonnées : <br><br>' . $contactFormData['civility'] . ' ' . $contactFormData['lastname'] . ' ' . $contactFormData['firstname'] . '<br>Entreprise/Association : ' . $contactFormData['society'] . '<br>Adresse mail : ' . $contactFormData['email'] . '<br>Téléphone : ' . $contactFormData['phone'] . '<br>Lieu : ' . $contactFormData['postal'] . ', ' . $contactFormData['city'];
            $mailer->sendEmail(subject: $subject, content: $content);
            $this->addFlash('success', 'Votre message a été envoyé. Nous reviendrons vers vous dans les plus brefs délais.');
            
        }

        return $this->render('contact/contact.html.twig', [
            'formContact' => $form->createView(),
        ]);
    }
}
