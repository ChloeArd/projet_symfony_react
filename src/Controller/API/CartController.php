<?php

namespace App\Controller\API;

use App\Entity\CartItem;
use App\Repository\ProductRepository;
use App\Service\SessionCartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/cart', name: 'api_cart', methods: ['GET'])]
    public function index(SessionCartService $sessionCartService): JsonResponse
    {
        return $this->json($sessionCartService->getCart());
    }

    #[Route('/api/cart/add', methods: ['POST'])]
    public function addToCart(Request $request, ProductRepository $productRepository, SessionCartService $sessionCartService): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);
        if (!isset($payload['product_id']) || !isset($payload['quantity'])) {
            return $this->returnError('Il manque des paramètres');
        }

        $product = $productRepository->find((int)$payload['product_id']);
        $quantity = (int)$payload['quantity']; // = -1 or +1

        if(null === $product) {
            return $this->returnError("Le produit n'existe plus ou pas dans notre catalogue");
        }

        $cart = $sessionCartService->getCart();
        $cartItem = $cart->getCartItem($product);

        // Le cart item n'existe pas, on l'ajoute avec une quantité "1"
        if(null === $cartItem && $quantity === 1) {
            $cartItem = (new CartItem())
                ->setProduct($product)
                ->setCart($cart)
                ->setQuantity(1);
        }
        // Si le cart existe et que la quantité passée et actuelle donne 0, on supprime le produit au cart
        elseif ($cartItem && $cartItem->getQuantity() + $quantity <= 0) {
            $this->entityManager->remove($cartItem);
            $product->setStock($product->getStock() + -$quantity);
            $this->entityManager->flush();
            $this->entityManager->refresh($cart);
            return $this->json($cart); // Refresh et return sinon le cart item s'ajoute a nouveau avec dernière quantité connue
        }
        // On gère le cas ou le stock est à 0
        elseif ($product->getStock() === 0 && $quantity !== -1) {
            return $this->returnError("Le stock ne permet pas d'ajouter autant de ce produit");
        }
        // Cas normal si le produit est déjà dans le panier
        elseif ($cartItem && $cartItem->getQuantity() + $quantity > 0) {
            // Mise à jour de la quantité pour le cart item (existant ou nouveau)
            $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
        }
        // On gère le cas ou on nous demande autre chose
        else {
            return $this->returnError("Vous tentez d'ajouter une quantité 0 ou moins d'un produit, c'est impossible");
        }

        $product->setStock($product->getStock() + -$quantity);
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();
        $this->entityManager->refresh($cart);

        return $this->json($cart);
    }

    private function returnError(string $errorMessage): JsonResponse
    {
        return $this->json([
            'error' => true,
            'message' => $errorMessage
        ]);
    }

    #[Route('/api/cart/delete', name: 'api_cart_delete')]
    public function deleteCart(SessionCartService $sessionCartService): JsonResponse
    {
        $sessionCartService->deleteSessionCart();
        return $this->json(['status' => true]);
    }
}