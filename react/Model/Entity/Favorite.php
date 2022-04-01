<?php

namespace Model\Entity;

class Favorite
{
    private ?int $id;
    private ?User $user_fk;
    private ?Article $article_fk;


    public function __construct(?int $id = null, ?User $user_fk = null, ?Article $article_fk = null)
    {
        $this->id = $id;
        $this->user_fk = $user_fk;
        $this->article_fk = $article_fk;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User|null
     */
    public function getUserFk(): ?User
    {
        return $this->user_fk;
    }

    /**
     * @param User|null $user_fk
     * @return User|null
     */
    public function setUserFk(?User $user_fk): ?User
    {
        $this->user_fk = $user_fk;
        return $user_fk;
    }

    /**
     * @return Article|null
     */
    public function getArticleFk(): ?Article
    {
        return $this->article_fk;
    }

    /**
     * @param Article|null $article_fk
     * @return Article|null
     */
    public function setArticleFk(?Article $article_fk): ?Article
    {
        $this->article_fk = $article_fk;
        return $article_fk;
    }
}