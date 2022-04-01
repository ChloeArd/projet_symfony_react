<?php

namespace Model\Entity;

class Category extends \Model\Entity\Article
{
    private ?int $id;
    private ?string $name;

    /**
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(?int $id = null, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
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
     * @return int|null
     */
    public function setId(?int $id): ?int
    {
        $this->id = $id;
        return $id;
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
}