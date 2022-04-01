<?php

namespace Model\Entity;

class Article
{
    private ?int $id;
    private ?string $name;
    private ?string $image;
    private ?string $description;
    private ?int $price;
    private ?int $stock;
    private ?Category $category_fk;

    /**
     * @param int|null $id
     * @param string|null $name
     * @param string|null $image
     * @param string|null $description
     * @param int|null $price
     * @param int|null $stock
     * @param Category|null $category_fk
     */
    public function __construct(?int $id = null, ?string $name = null, ?string $image = null, ?string $description = null, ?int $price = null, ?int $stock = null, ?Category $category_fk = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category_fk = $category_fk;
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return string|null
     */
    public function setName(?string $name): ?string
    {
        $this->name = $name;
        return $name;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return string|null
     */
    public function setImage(?string $image): ?string
    {
        $this->image = $image;
        return $image;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return string|null
     */
    public function setDescription(?string $description): ?string
    {
        $this->description = $description;
        return $description;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     * @return int|null
     */
    public function setPrice(?int $price): ?int
    {
        $this->price = $price;
        return $price;
    }

    /**
     * @return int|null
     */
    public function getStock(): ?int
    {
        return $this->stock;
    }

    /**
     * @param int|null $stock
     * @return int|null
     */
    public function setStock(?int $stock): ?int
    {
        $this->stock = $stock;
        return $stock;
    }

    /**
     * @return Category|null
     */
    public function getCategoryFk(): ?Category
    {
        return $this->category_fk;
    }

    /**
     * @param Category|null $category_fk
     * @return Category|null
     */
    public function setCategoryFk(?Category $category_fk): ?Category
    {
        $this->category_fk = $category_fk;
        return $category_fk;
    }
}