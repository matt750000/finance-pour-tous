<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_products', methods: ['GET'])]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository, PaginatorInterface  $paginator, Request $request): Response
    {
        $search = $request->query->get('q');
        $categoryId = $request->query->get('category');
        $queryBuilder = $productRepository->createQueryBuilder('p')
            ->leftJoin('p.category', 'c')
            ->addSelect('c');

        if ($search) {
            $queryBuilder
                ->where('LOWER(p.name) LIKE LOWER(:search)')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($categoryId) {
            $queryBuilder
                ->andWhere('c.id = :category')
                ->setParameter('category', $categoryId);
        }

        $products = $paginator->paginate(
            #$productRepository->findAll(),
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        $categories = $categoryRepository->findAll(); // pour le menu déroulant

        return $this->render('pages/product/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'search' => $search,
        ]);
    }
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Product $product, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $cart[$product->getId()] = ($cart[$product->getId()] ?? 0) + 1;
        $session->set('cart', $cart);

        $this->addFlash('success', $product->getName() . ' ajouté au panier !');
        return $this->redirectToRoute('app_products');
    }
}
