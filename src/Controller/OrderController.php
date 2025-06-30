<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Service\OrderService;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function commander(
        Request $request,
        EntityManagerInterface $entityManager,
        OrderService $orderService,
        EmailService $emailService
    ): Response {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_login');
        }

        // 🧾 Affichage du formulaire
        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);

        // ✅ Soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // utilisateur connecté
            $formData = $form->getData(); // tableau avec name, address, etc.

            // 🛒 Création de la commande avec les produits du panier
            $order = $orderService->createOrder($formData, $user);

            // 📬 Envoi d’un email de confirmation
            $emailService->sendOrderConfirmation($user, $order);

            // ✅ Affichage de la page de confirmation
            return $this->render('pages/order/confirmation.html.twig', [
                'order' => $order,
            ]);
        }

        return $this->render('pages/order/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
