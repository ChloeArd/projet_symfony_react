<?php

namespace Model\Cart;

use JetBrains\PhpStorm\Pure;
use Model\Article\ArticleManager;
use Model\DB;
use Model\Entity\Cart;
use Model\Manager\Traits\ManagerTrait;
use Model\User\UserManager;

class CartManager
{

    use ManagerTrait;

    private ArticleManager $articleManager;
    private UserManager $userManager;

    #[Pure] public function __construct()
    {
        $this->articleManager = new ArticleManager();
        $this->userManager = new UserManager();
    }

    /**
     * Return a article based on id.
     * @param int $id
     * @return Cart
     */
    public function getCart(int $id): Cart
    {
        $request = DB::getInstance()->prepare("SELECT * FROM cart WHERE id = $id");
        $request->execute();
        $info = $request->fetch();
        $cart = new Cart();
        if ($info) {
            $cart->setId($info['id']);
            $cart->setQuantity($info['quantity']);
            $article = $this->articleManager->getArticle($info['article_fk']);
            $cart->setArticleFk($article);
            $user = $this->userManager->getUser($info['user_fk']);
            $cart->setUserFk($user);
        }
        return $cart;
    }

    /**
     * Return all articles
     * @param int $user_fk
     * @return array
     */
    public function getCartOfUser(int $user_fk): array
    {
        $cart = [];
        $request = DB::getInstance()->prepare("SELECT * FROM cart WHERE user_fk = :user_fk");
        $request->bindParam(':user_fk', $user_fk);
        $request->execute();
        $roles_response = $request->fetchAll();
        if ($roles_response) {
            foreach ($roles_response as $info) {
                $user = $this->userManager->getUser($user_fk);
                $article = $this->articleManager->getArticle($info['article_fk']);
                if ($user->getId() && $article->getId()) {
                    $cart[] = new Cart($info['id'], $info['quantity'], $article, $user);
                }
            }
        }
        return $cart;
    }

    /**
     * Add a article in cart to user
     * @param Cart $cart
     * @return bool
     */
    public function add(Cart $cart): bool
    {
        $request = DB::getInstance()->prepare("
            INSERT INTO article (quantity, article_fk, user_fk)
                VALUES (:quantity, :article_fk, :user_fk) 
        ");

        $request->bindValue(':quantity', 1);
        $request->bindValue(':article_fk', $cart->getArticleFk()->getId());
        $request->bindValue(':user_fk', $cart->getUserFk()->getId());

        return $request->execute() && DB::getInstance()->lastInsertId() != 0;
    }

    /**
     * update cart
     * @param Cart $cart
     * @return bool
     */
    public function update(Cart $cart): bool
    {
        $request = DB::getInstance()->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id");
        $request->bindValue(':id', $cart->getId());
        $request->bindValue(':quantity', $cart->setQuantity($cart->getQuantity()));

        return $request->execute();
    }


    /**
     * Delete a article and remove item from cart.
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        $request = DB::getInstance()->prepare("DELETE FROM cart WHERE id = :id");
        $request->bindValue(":id", $id);
        return $request->execute();
    }

    /**
     * Delete all of a user's cart
     * @return int
     */
    public function deleteAllCart(): int
    {
        $request = DB::getInstance()->prepare("DELETE FROM cart WHERE user_fk = :user_fk");
        $request->bindValue(":user_fk", $_SESSION['id']);
        return $request->execute();
    }
}