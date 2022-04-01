<?php
session_start();
require_once '../../../Model/DB.php';
require_once '../../../Model/Entity/Article.php';
require_once '../../../Model/Manager/ArticleManager.php';


use Model\Article\ArticleManager;
use Model\Category\CategoryManager;
use Model\Entity\Article;

header('Content-Type: application/json');

$requestType = $_SERVER['REQUEST_METHOD'];
$manager = new ArticleManager();

switch ($requestType) {
    case 'GET':
        if(isset($_GET['id'])) {
            echo getArticle($manager, intval($_GET['id']));
        }
        elseif (isset($_GET['category'])) {
            echo getArticlesByCategory($manager, intval($_GET['category']));
        }
        else {
            echo getArticles($manager);
        }
        break;

    case 'POST':
        $response = [
            'error' => 'success',
            'message' => 'L\'article a été créé avec succès.',
        ];

        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->name, $data->image, $data->description, $data->price, $data->stock, $data->category_fk)) {

            $name = htmlentities(trim(ucfirst($data->name)));
            $image = htmlentities(trim(ucfirst($data->image)));
            $description = htmlentities(trim(ucfirst($data->description)));
            $price = intval(trim($data->price));
            $stock = intval(trim($data->stock));
            $category_fk = intval(trim($data->category_fk));

            $category = CategoryManager::getManager()->getCategory($category_fk);

            $article = new Article(null, $name, $image, $description, $price, $stock, $category);
            $result = $manager->add($article);
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
            'message' => 'L\'article a été modifié avec succès.',
        ];

        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->id, $data->name, $data->image, $data->description, $data->price, $data->stock, $data->category_fk)) {

            $id = intval($data->id);
            $name = htmlentities(trim(ucfirst($data->name)));
            $image = htmlentities(trim(ucfirst($data->image)));
            $description = htmlentities(trim(ucfirst($data->description)));
            $price = intval(trim($data->price));
            $stock = intval(trim($data->stock));
            $category_fk = intval(trim($data->category_fk));
            $category = CategoryManager::getManager()->getCategory($category_fk);

            $article = new Article($id, $name, $image, $description, $price, $stock, $category);
            $result = $manager->update($article);
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
            'message' => 'L\'article a été supprimé avec succès.',
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
 * Return all articles
 * @param ArticleManager $manager
 * @return string
 */
function getArticles(ArticleManager $manager): string {
    $response = [];
    $data = $manager->getArticles();
    foreach ($data as $article) {
        $response[] = [
            'id' => $article->getId(),
            'name' => $article->getName(),
            'image' => $article->getImage(),
            'description' => $article->getDescription(),
            'price' => $article->getPrice(),
            'stock' => $article->getStock(),
            'category' => [
                'id' => $article->getCategoryFk()->getId(),
                'name' => $article->getCategoryFk()->getName()
            ]
        ];
    }
    return json_encode($response);
}

/** Return all article by category
 * @param ArticleManager $manager
 * @param int $category
 * @return string
 */
function getArticlesByCategory(ArticleManager $manager, int $category): string {
    $response = [];
    $data = $manager->getArticlesByCategory($category);
    foreach ($data as $article) {
        $response[] = [
            'id' => $article->getId(),
            'name' => $article->getName(),
            'image' => $article->getImage(),
            'description' => $article->getDescription(),
            'price' => $article->getPrice(),
            'stock' => $article->getStock(),
            'category' => [
                'id' => $article->getCategoryFk()->getId(),
                'name' => $article->getCategoryFk()->getName()
            ]
        ];
    }
    return json_encode($response);
}

/**
 * Return one article
 * @param ArticleManager $manager
 * @param int $id
 * @return string
 */
function getArticle(ArticleManager $manager, int $id): string {
    $response = [];
    $data = $manager->getArticle($id);
    foreach ($data as $article) {
        $response[] = [
            'id' => $article->getId(),
            'name' => $article->getName(),
            'image' => $article->getImage(),
            'description' => $article->getDescription(),
            'price' => $article->getPrice(),
            'stock' => $article->getStock(),
            'category' => [
                'id' => $article->getCategoryFk()->getId(),
                'name' => $article->getCategoryFk()->getName()
            ]
        ];
    }
    return json_encode($response);
}