<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'view_cart')]
    public function index(CartService $cartService): Response
    {
        $cartItems = $cartService->getDetailedCartItems();
        $total = $cartService->getTotal();

        return $this->render('pages/cart/index.html.twig', [
            'items' => $cartItems,
            'total' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Product $product, CartService $cartService): Response
    {
        $cartService->add($product);
        $this->addFlash('success', $product->getName() . ' ajouté au panier !');

        return $this->redirectToRoute('app_products');
    }

    #[Route('/cart/remove/{id}', name: 'remove_from_cart')]
    public function remove(Product $product, CartService $cartService): Response
    {
        $cartService->remove($product);

        return $this->redirectToRoute('view_cart');
    }
}
