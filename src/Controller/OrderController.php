<?php

namespace App\Controller;

use App\Form\OrderTypeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function commander(Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(OrderTypeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // ici tu pourrais stocker la commande dans la base

            return $this->render('order/confirmation.html.twig', [
                'donnees' => $data,
                'panier' => $session->get('panier', []),
            ]);
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
