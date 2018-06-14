<?php

namespace BeHappy\SyliusCartManagementPlugin\Entity;

use Sylius\Component\Core\Model\ProductVariantInterface;

class SavedCartItem
{
    /** @var int */
    protected $id;
    /** @var ProductVariantInterface */
    protected $product = null;
    /** @var int */
    protected $quantity;
    /** @var SavedCart */
    protected $savedCart = null;

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
     * @return ProductVariantInterface
     */
    public function getProduct(): ProductVariantInterface
    {
        return $this->product;
    }

    /**
     * @param ProductVariantInterface $product
     */
    public function setProduct(ProductVariantInterface $product): void
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return SavedCart
     */
    public function getSavedCart(): SavedCart
    {
        return $this->savedCart;
    }

    /**
     * @param SavedCart $savedCart
     */
    public function setSavedCart(SavedCart $savedCart): void
    {
        $this->savedCart = $savedCart;
    }
}
