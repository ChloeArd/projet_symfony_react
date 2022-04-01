<?php
session_start();
require_once '../../../Model/DB.php';
require_once '../../../Model/Entity/Favorite.php';
require_once '../../../Model/Manager/FavoriteManager.php';


use Model\Article\ArticleManager;
use Model\Entity\Favorite;
use Model\Favorite\FavoriteManager;

header('Content-Type: application/json');

$requestType = $_SERVER['REQUEST_METHOD'];
$manager = new FavoriteManager();

switch ($requestType) {
    case 'GET':
        if(isset($_GET['id'])) {
            echo getFavorite($manager, intval($_GET['id']));
        }
        break;

    case 'POST':
        $response = [
            'error' => 'success',
            'message' => 'L\'article a été ajouté dans vos favoris.',
        ];

        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->article_fk)) {

            $article_fk = intval(trim($data->article_fk));
            $article = ArticleManager::getManager()->getArticle($article_fk);

            $favorite = new Favorite(null, $_SESSION['id'], $article);
            $result = $manager->add($favorite);
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
                'message' => 'L\'id de l\'article est manquant.',
            ];
        }
        echo json_encode($response);
        break;

    case 'DELETE' :
        $response = [
            'error' => 'success',
            'message' => 'L\'article a été supprimé de vos favoris.',
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
            $response = [
                'error' => 'error2',
                'message' => 'L\'id est manquant.',
            ];
        }
        echo json_encode($response);
        break;
}

/**
 * Return the favorite of user
 * @param FavoriteManager $manager
 * @return false|string
 */
function getFavorite(FavoriteManager $manager, int $article_fk): string {
    $response = [];
    $data = $manager->favorite($article_fk, $_SESSION['id']);
    foreach ($data as $favorite) {
        $response[] = [
            'id' => $favorite->getId(),
            'article' => [
                'id' => $favorite->getArticleFk()->getId(),
                'name' => $favorite->getArticleFk()->getName()
            ],
            'user' => [
                'id' => $favorite->getUserFk()->getId(),
                'firstname' => $favorite->getUserFk()->getFirstname(),
                'lastname' => $favorite->getUserFk()->getLastname()
            ]
        ];
    }
    return json_encode($response);
}