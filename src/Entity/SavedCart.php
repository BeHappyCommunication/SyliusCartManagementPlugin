<?php

namespace BeHappy\SyliusCartManagementPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class SavedCart implements TimestampableInterface, ResourceInterface
{
    use TimestampableTrait;

    /** @var int */
    protected $id;
    /** @var string */
    protected $token = "";
    /** @var SavedCartItem[]|Collection|null */
    protected $savedCartItems = [];
    /** @var ShopUserInterface */
    protected $user;
    /** @var string */
    protected $name;

    public function __construct()
    {
        $this->setSavedCartItems(new ArrayCollection());
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function generateToken(): void
    {
        $random = substr(sha1(uniqid('', true)), 0, 20);

        $this->setToken($random);
    }

    public function create(): void
    {
        $this->generateToken();
        $this->setCreatedAt(new \DateTime());
    }

    public function update(): void
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @return SavedCartItem[]|Collection|null
     */
    public function getSavedCartItems()
    {
        return $this->savedCartItems;
    }

    /**
     * @param SavedCartItem[]|Collection|null $savedCartItems
     */
    public function setSavedCartItems($savedCartItems): void
    {
        $this->savedCartItems = $savedCartItems;
    }

    /**
     * @return ShopUserInterface
     */
    public function getUser(): ShopUserInterface
    {
        return $this->user;
    }

    /**
     * @param ShopUserInterface $user
     */
    public function setUser(ShopUserInterface $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
