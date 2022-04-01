<?php
namespace Model\Favorite;

use Model\Article\ArticleManager;
use Model\DB;
use Model\Entity\Favorite;
use Model\Manager\Traits\ManagerTrait;
use Model\User\UserManager;

class FavoriteManager {

    use ManagerTrait;

    /**
     * See if the user has bookmarked the article.
     * @param $article_fk
     * @param $user_fk
     * @return array
     */
    public function favorite($article_fk, $user_fk): array {
        $favorites = [];
        $request = DB::getInstance()->prepare("SELECT * FROM favorite WHERE user_fk = :user_fk AND article_fk = :article_fk ");
        $request->bindParam(":user_fk", $user_fk);
        $request->bindParam(":article_fk", $article_fk);
        $result = $request->execute();
        if($result) {
            foreach ($request->fetchAll() as $info) {
                $user = UserManager::getManager()->getUser($user_fk);
                $article = ArticleManager::getManager()->getArticle($article_fk);
                if($user->getId() && $article->getId()) {
                    $favorites[] = new Favorite($info['id'], $user, $article);
                }
            }
        }
        return $favorites;
    }

    /**
     * add an article to favorites.
     * @param Favorite $favorite
     * @return bool
     */
    public function add (Favorite $favorite): bool {
        $request = DB::getInstance()->prepare("SELECT * FROM favorite WHERE user_fk = :user_fk AND article_fk = :article_fk ");
        $request->bindValue(':user_fk', $favorite->getUserFk()->getId());
        $request->bindValue(':article_fk', $favorite->getArticleFk()->getId());
        $request->execute();
        $favoriteFind = $request->fetch();
        // We check if the user has not already put the ad in his favorites.
        // If this is the case, we add the ad to our favorites.
        if ($favoriteFind['user_fk'] != $favorite->getUserFk()->getId() && $favoriteFind['article_fk'] != $favorite->getArticleFk()->getId()) {
            $request = DB::getInstance()->prepare("INSERT INTO favorite (user_fk, article_fk) VALUES (:user_fk, :article_fk)");
            $request->bindValue(':user_fk', $favorite->getUserFk()->getId());
            $request->bindValue(':article_fk', $favorite->getArticleFk()->getId());
        }

        return $request->execute() && DB::getInstance()->lastInsertId() != 0;
    }

    /**
     * Delete a article to favorites.
     * @param int $id
     * @return bool
     */
    public function delete (int $id): bool {
        $request = DB::getInstance()->prepare("DELETE FROM favorite WHERE id = :id");
        $request->bindValue(":id", $id);
        return $request->execute();
    }
}