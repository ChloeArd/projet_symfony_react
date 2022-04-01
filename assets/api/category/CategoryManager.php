<?php
session_start();
require_once '../../../Model/DB.php';
require_once '../../../Model/Entity/Category.php';
require_once '../../../Model/Manager/CategoryManager.php';


use Model\Category\CategoryManager;
use Model\Entity\Category;

header('Content-Type: application/json');

$requestType = $_SERVER['REQUEST_METHOD'];
$manager = new CategoryManager();

switch ($requestType) {
    case 'GET':
        if(isset($_GET['id'])) {
            echo getCategory($manager, intval($_GET['id']));
        }
        else {
            echo getCategories($manager);
        }
        break;

    case 'POST':
        $response = [
            'error' => 'success',
            'message' => 'La catégorie a été créée avec succès.',
        ];

        $data = json_decode(file_get_contents('php://input'));
        if (isset($data->name)) {

            $name = htmlentities(trim(ucfirst($data->name)));

            $category = new Category(null, $name);
            $result = $manager->add($category);
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
                'message' => 'Le nom est manquant.',
            ];
        }
        echo json_encode($response);
        break;

    case 'DELETE' :
        $response = [
            'error' => 'success',
            'message' => 'La catégorie a été supprimé avec succès.',
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
 * Return the category
 * @param CategoryManager $manager
 * @return string
 */
function getCategory(CategoryManager $manager, int $id): string {
    $response = [];
    $data = $manager->getCategory($id);
    foreach ($data as $user) {
        $response[] = [
            'id' => $user->getId(),
            'name' => $user->getName(),
        ];
    }
    return json_encode($response);
}

/**
 * Return all categories
 * @param CategoryManager $manager
 * @return string
 */
function getCategories(CategoryManager $manager): string {
    $response = [];
    $data = $manager->getCategories();
    foreach ($data as $user) {
        $response[] = [
            'id' => $user->getId(),
            'name' => $user->getName(),
        ];
    }
    return json_encode($response);
}