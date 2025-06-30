<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Response to the admin
            $adminMessage = (new Email())
                ->from($data['email'])
                ->to('contact@monsite.com') // Ton adresse pro
                ->subject($data['subject'])
                ->text("Message reçu de : {$data['fullName']}\n\n{$data['message']}");
            $mailer->send($adminMessage);

            //  Response to the visitor
            $confirmation = (new Email())
                ->from('noreply@monsite.com')
                ->to($data['email'])
                ->subject('Merci pour votre message')
                ->text("Bonjour {$data['fullName']},\n\nNous avons bien reçu votre message concernant \"{$data['subject']}\".\nNotre équipe vous répondra dans les plus brefs délais.\n\n— L'équipe de MonSite");
            $mailer->send($confirmation);

            $this->addFlash('success', 'Votre message a bien été envoyé ! Un accusé de réception vous a été adressé.');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('pages/contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
