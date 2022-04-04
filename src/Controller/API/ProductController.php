<?php

namespace App\Controller\API;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    #[Route('/api/products', name: 'api_products')]
    public function index(): JsonResponse
    {
        return $this->json($this->productRepository->findAll());
    }
}
