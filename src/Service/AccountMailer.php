<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\User;

class AccountMailer
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendProfileUpdatedEmail(User $user): void
    {
        $email = (new Email())
            ->from('commande@tonsite.fr')
            ->to($user->getEmail())
            ->subject('Modification de votre profil')
            ->text('Bonjour ' . $user->getFirstName() . ', votre profil a été mis à jour.');

        $this->mailer->send($email);
    }
}
