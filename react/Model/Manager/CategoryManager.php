<?php
namespace Model\Category;

use Model\DB;
use Model\Entity\Category;
use Model\Manager\Traits\ManagerTrait;

class CategoryManager {

    use ManagerTrait;

    /**
     * Return a category based on id.
     * @param int $id
     * @return Category
     */
    public function getCategory(int $id): Category
    {
        $request = DB::getInstance()->prepare("SELECT * FROM category WHERE id = $id");
        $request->execute();
        $info = $request->fetch();
        $category = new Category();
        if ($info) {
            $category->setId($info['id']);
            $category->setName($info['name']);
        }
        return $category;
    }

    /**
     * Return all categories
     * @return array
     */
    public function getCategories(): array
    {
        $categories = [];
        $request = DB::getInstance()->prepare("SELECT * FROM category");
        $request->execute();
        $roles_response = $request->fetchAll();
        if ($roles_response) {
            foreach ($roles_response as $info) {
                $categories[] = new Category($info['id'], $info['name']);
            }
        }
        return $categories;
    }

    /**
     * Display a user based on id.
     * @param int $id
     * @return array
     */
    public function getCategoryID(int $id): array {
        $category = [];
        $request = DB::getInstance()->prepare("SELECT * FROM category WHERE id = :id");
        $request->bindParam(":id", $id);
        if($request->execute()) {
            foreach($request->fetchAll() as $info) {
                $category[] = new Category($info['id'], $info['name']);
            }
        }
        return $category;
    }

    /**
     * Add a category
     * @param Category $category
     * @return bool
     */
    public function add (Category $category): bool
    {
        $request = DB::getInstance()->prepare("
            INSERT INTO category (name)
                VALUES (:name) 
        ");

        $request->bindValue(':name', $category->getName());

        return $request->execute() && DB::getInstance()->lastInsertId() != 0;
    }

    public function delete(int $id) : int {
        $request = DB::getInstance()->prepare("UPDATE article SET category_fk = :category_fk_update WHERE category_fk = :category_fk");
        $request->bindValue(":category_fk_update", 0);
        $request->bindValue(":category_fk",$id);
        $request->execute();
        $request = DB::getInstance()->prepare("DELETE FROM category WHERE id = :id");
        $request->bindValue(":id", $id);
        return $request->execute();
    }
}