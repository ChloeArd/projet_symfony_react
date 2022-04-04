<?php

namespace App\Controller\API;

use App\Service\SessionCartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/api/cart', name: 'api_cart', methods: ['GET'])]
    public function index(SessionCartService $sessionCartService): JsonResponse
    {
        return $this->json($sessionCartService->getCart());
    }
}
