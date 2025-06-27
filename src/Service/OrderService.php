<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    private EntityManagerInterface $em;
    private CartService $cartService;

    public function __construct(EntityManagerInterface $em, CartService $cartService)
    {
        $this->em = $em;
        $this->cartService = $cartService;
    }

    /**
     * Crée une commande complète à partir d'un objet Order existant et du panier
     *
     * @param Order $order Objet rempli depuis le formulaire
     * @param User $user L'utilisateur connecté
     * @return Order La commande sauvegardée
     */
    public function createOrder(Order $order, User $user): Order
    {
        // Ajoute l’utilisateur et la date de création
        $order->setUser($user);
        $order->setCreatedAt(new \DateTimeImmutable());

        $total = 0;

        // Ajoute les produits du panier
        foreach ($this->cartService->getDetailedCartItems() as $item) {
            $orderItem = new OrderItem();
            $orderItem->setProduct($item['product']);
            $orderItem->setQuantity($item['quantity']);
            $orderItem->setOrderRef($order);

            $this->em->persist($orderItem);

            $total += $item['subtotal'];
        }

        // Définir le total
        $order->setTotalPrice($total);

        // Sauvegarder
        $this->em->persist($order);
        $this->em->flush();

        // Vider le panier
        $this->cartService->clear();

        return $order;
    }
}
