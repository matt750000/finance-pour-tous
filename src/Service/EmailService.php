<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendOrderConfirmation(User $user, Order $order): void
    {
        $email = (new TemplatedEmail())
            ->from('commande@tonsite.fr')
            ->to($user->getEmail())
            ->subject('Confirmation de votre commande')
            ->htmlTemplate('emails/confirmation.html.twig')
            ->context([
                'user' => $user,
                'order' => $order,
            ]);

        $this->mailer->send($email);
    }
}
