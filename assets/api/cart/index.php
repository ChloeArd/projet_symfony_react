<?php
session_start();
require_once '../../../Model/DB.php';
require_once '../../../Model/Entity/Cart.php';
require_once '../../../Model/Manager/CartManager.php';


use Model\Article\ArticleManager;
use Model\Cart\CartManager;
use Model\Entity\Cart;
use Model\User\UserManager;

header('Content-Type: application/json');

$requestType = $_SERVER['REQUEST_METHOD'];
$manager = new CartManager();

switch ($requestType) {
    case 'GET':
        if(isset($_SESSION['id'])) {
            echo getCartOfUser($manager);
        }
        break;

    case 'POST':
        $response = [
            'error' => 'success',
            'message' => 'L\'article a été ajouté avec succès à votre panier.',
        ];

        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->article_fk)) {

            $article_fk = intval(trim($data->article_fk));

            $article = ArticleManager::getManager()->getArticle($article_fk);
            $user = UserManager::getManager()->getUser($_SESSION['id']);

            $cart = new Cart(null, 1, $article, $user);
            $result = $manager->add($cart);
            if (!$result) {
                $response = [
                    'error' => 'error1',
                    'message' => 'Une erreur est survenue.',
                ];
            }
            else {
                $response = [
                    'error' => 'error2',
                    'message' => 'Il y a eu un problème.',
                ];
            }
        }
        else {
            $response = [
                'error' => 'error3',
                'message' => 'Il y a un ou plusieurs élément(s) manquant(s).',
            ];
        }
        echo json_encode($response);
        break;

    case 'PUT':
        $response = [
            'error' => 'success',
            'message' => 'La quantité de votre article a été modifié.',
        ];

        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->id, $data->quantity)) {

            $id = intval($data->id);
            $quantity = htmlentities(trim(ucfirst($data->quantity)));

            $cart = new Cart($id, $quantity);
            $result = $manager->update($cart);
            if (!$result) {
                $response = [
                    'error' => 'error1',
                    'message' => 'Une erreur est survenue.',
                ];
            }
            else {
                $response = [
                    'error' => 'error2',
                    'message' => 'Il y a eu un problème.',
                ];
            }
        }
        else {
            $response = [
                'error' => 'error3',
                'message' => 'Il y a un ou plusieurs élément(s) manquant(s).',
            ];
        }

        echo json_encode($response);
        break;

    case 'DELETE' :
        $response = [
            'error' => 'success',
            'message' => 'L\'article a été supprimé du panier avec succès.',
        ];

        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->id)) {
            $id = intval($data->id);
            $result = $manager->delete($id);

            if (!$result) {
                $response = [
                    'error' => 'error1',
                    'message' => 'Une erreur est survenue.',
                ];
            }
        }
        else {
            $result = $manager->deleteAllCart();

            if (!$result) {
                $response = [
                    'error' => 'error1',
                    'message' => 'Une erreur est survenue.',
                ];
            }
        }
        echo json_encode($response);
        break;
}

/**
 * Return a cart of user
 * @param CartManager $manager
 * @return string
 */
function getCartOfUser(CartManager $manager): string {
    $response = [];
    $data = $manager->getCartOfUser($_SESSION['id']);
    foreach ($data as $cart) {
        $response[] = [
            'id' => $cart->getId(),
            'quantity' => $cart->getQuantity(),
            'article' => [
                'id' => $cart->getArticleFk()->getId(),
                'name' => $cart->getArticleFk()->getName(),
                'price' => $cart->getArticleFk()->getPrice(),
                'stock' => $cart->getArticleFk()->getStock()
            ],
            'user' => [
                'id' => $cart->getUserFk()->getId(),
                'firstname' => $cart->getUserFk()->getFirstname(),
                'lastname' => $cart->getUserFk()->getLastname()
            ]
        ];
    }
    return json_encode($response);
}