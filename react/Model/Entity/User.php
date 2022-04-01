<?php

namespace Model\Entity;

class User
{
    private ?int $id;
    private ?string $firstname;
    private ?string $lastname;
    private ?string $email;
    private ?string $phone;
    private ?string $password;
    private ?Role $role_fk;

    /**
     * @param int|null $id
     * @param string|null $firstname
     * @param string|null $lastname
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $password
     * @param Role|null $role_fk
     */
    public function __construct(?int $id = null, ?string $firstname = null, ?string $lastname = null, ?string $email = null, ?string $phone = null, ?string $password = null, ?Role $role_fk = null)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->role_fk = $role_fk;
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
     * @return int
     */
    public function setId(?int $id): int
    {
        $this->id = $id;
        return $id;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return string
     */
    public function setFirstname(?string $firstname): string
    {
        $this->firstname = $firstname;
        return $firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     * @return string
     */
    public function setLastname(?string $lastname): string
    {
        $this->lastname = $lastname;
        return $lastname;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return string|null
     */
    public function setEmail(?string $email): ?string
    {
        $this->email = $email;
        return $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return string|null
     */
    public function setPhone(?string $phone): ?string
    {
        $this->phone = $phone;
        return $phone;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return string|null
     */
    public function setPassword(?string $password): ?string
    {
        $this->password = $password;
        return $password;
    }

    /**
     * @return Role|null
     */
    public function getRoleFk(): ?Role
    {
        return $this->role_fk;
    }

    /**
     * @param Role|null $role_fk
     * @return Role|null
     */
    public function setRoleFk(?Role $role_fk): ?Role
    {
        $this->role_fk = $role_fk;
        return $role_fk;
    }
}