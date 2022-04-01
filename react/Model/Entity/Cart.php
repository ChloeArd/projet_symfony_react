<?php

namespace Model\Entity;

class Cart
{
    private ?int $id;
    private ?int $quantity;
    private Article $article_fk;
    private User $user_fk;


    /**
     * @param int|null $id
     * @param int|null $quantity
     * @param Article|null $article_fk
     * @param User|null $user_fk
     */
    public function __construct(?int $id = null, ?int $quantity = null, ?Article $article_fk = null, ?User $user_fk = null)
    {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->article_fk = $article_fk;
        $this->user_fk = $user_fk;
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
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return int|null
     */
    public function setQuantity(?int $quantity): ?int
    {
        $this->quantity = $quantity;
        return $quantity;
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
}