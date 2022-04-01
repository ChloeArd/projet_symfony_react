<?php
namespace Model\Article;

use JetBrains\PhpStorm\Pure;
use Model\Category\CategoryManager;
use Model\DB;
use Model\Entity\Article;
use Model\Manager\Traits\ManagerTrait;

class ArticleManager {

    use ManagerTrait;

    private CategoryManager $categoryManager;

    #[Pure] public function __construct() {
        $this->categoryManager = new CategoryManager();
    }

    /**
     * Return a article based on id.
     * @param int $id
     * @return Article
     */
    public function getArticle(int $id): Article
    {
        $request = DB::getInstance()->prepare("SELECT * FROM article WHERE id = $id");
        $request->execute();
        $info = $request->fetch();
        $article = new Article();
        if ($info) {
            $article->setId($info['id']);
            $article->setName($info['name']);
            $article->setImage($info['image']);
            $article->setDescription($info['description']);
            $article->setPrice($info['price']);
            $article->setStock($info['stock']);
            $category = $this->categoryManager->getCategory($info['category_fk']);
            $article->setCategoryFk($category);
        }
        return $article;
    }

    /**
     * Return all articles
     * @return array
     */
    public function getArticles(): array
    {
        $articles = [];
        $request = DB::getInstance()->prepare("SELECT * FROM article");
        $request->execute();
        $roles_response = $request->fetchAll();
        if ($roles_response) {
            foreach ($roles_response as $info) {
                $category = $this->categoryManager->getCategory($info['category_fk']);
                if($category->getId()) {
                    $articles[] = new Article($info['id'], $info['name'], $info['image'], $info['description'], $info['price'], $category);
                }
            }
        }
        return $articles;
    }

    /** All articles by category
     * @param $category_fk
     * @return array
     */
    public function getArticlesByCategory($category_fk): array
    {
        $articles = [];
        $request = DB::getInstance()->prepare("SELECT * FROM article WHERE category_fk = :category_fk");
        $request->bindParam(":category_fk", $category_fk);
        $request->execute();
        $roles_response = $request->fetchAll();
        if ($roles_response) {
            foreach ($roles_response as $info) {
                $category = $this->categoryManager->getCategory($info['category_fk']);
                if ($category->getId()) {
                    $articles[] = new Article($info['id'], $info['name'], $info['image'], $info['description'], $info['price'], $category);
                }
            }
        }
        return $articles;
    }

    /**
     * Add a article
     * @param Article $article
     * @return bool
     */
    public function add (Article $article): bool
    {
        $request = DB::getInstance()->prepare("
            INSERT INTO article (name, image, description, price, stock, category_fk)
                VALUES (:name, :image, :description, :price, :stock, :category_fk) 
        ");

        $request->bindValue(':name', $article->getName());
        $request->bindValue(':image', $article->getImage());
        $request->bindValue(':description', $article->getDescription());
        $request->bindValue(':price', $article->getPrice());
        $request->bindValue(':stock', $article->getStock());
        $request->bindValue(':category_fk', $article->getCategoryFk()->getId());


        return $request->execute() && DB::getInstance()->lastInsertId() != 0;
    }

    /**
     * update article
     * @param Article $article
     * @return bool
     */
    public function update(Article $article): bool {
        $request = DB::getInstance()->prepare("UPDATE article SET name = :name, image = :image, description = :description, price = :price, stock = :stock, category_fk = :category_fk WHERE id = :id");
        $request->bindValue(':id', $article->getId());
        $request->bindValue(':name', $article->setName($article->getName()));
        $request->bindValue(':image', $article->setImage($article->getImage()));
        $request->bindValue(':description', $article->setDescription($article->getDescription()));
        $request->bindValue(':price', $article->setPrice($article->getPrice()));
        $request->bindValue(':stock', $article->setStock($article->getStock()));
        $request->bindValue(':category_fk', $article->setCategoryFk($article->getCategoryFk())->getId());

        return $request->execute();
    }


    /**
     * Delete a article and remove item from cart.
     * @param int $id
     * @return int
     */
    public function delete(int $id) : int {
        $request = DB::getInstance()->prepare("DELETE FROM cart WHERE article_fk = :article_fk");
        $request->bindValue(":article_fk", $id);
        $request->execute();
        $request = DB::getInstance()->prepare("DELETE FROM article WHERE id = :id");
        $request->bindValue(":id", $id);
        return $request->execute();
    }
}