<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_products', methods: ['GET'])]
    public function index(ProductRepository $productRepository, PaginatorInterface  $paginator, Request $request): Response
    {
        $products = $paginator->paginate(
            $productRepository->findAll(),
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        return $this->render('pages/product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/products/{id<\d+>}', name: 'app_product')]
    public function show(Product $product): Response
    {
        return $this->render('pages/product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
