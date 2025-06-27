<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $session;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->session = $requestStack->getSession();
        $this->productRepository = $productRepository;
    }

    // ➕ add a product from the cart
    public function add(Product $product): void
    {
        $cart = $this->session->get('cart', []);
        $id = $product->getId();

        $cart[$id] = ($cart[$id] ?? 0) + 1;
        $this->session->set('cart', $cart);
    }

    // ❌ Remove a product from the cart
    public function remove(Product $product): void
    {
        $cart = $this->session->get('cart', []);
        $id = $product->getId();

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        $this->session->set('cart', $cart);
    }

    public function getDetailedCartItems(): array
    {
        $cart = $this->session->get('cart', []);
        $items = [];

        foreach ($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->getPrice() * $quantity,
                ];
            }
        }

        return $items;
    }

    public function getTotal(): float
    {
        $items = $this->getDetailedCartItems();
        return array_sum(array_column($items, 'subtotal'));
    }

    // 🧹 Vider le panier
    public function clear(): void
    {
        $this->session->remove('cart');
    }

    // 🔄 Obtenir le panier brut (id => quantité)
    public function getCart(): array
    {
        return $this->session->get('cart', []);
    }
}
