<?php

namespace BeHappy\SyliusCartManagementPlugin\Service;

use BeHappy\SyliusCartManagementPlugin\Entity\SavedCart;
use BeHappy\SyliusCartManagementPlugin\Entity\SavedCartItem;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class CartService
 * @package BeHappy\SyliusCartManagementPlugin\Service
 */
class CartService implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param OrderInterface $cart
     *
     * @return SavedCart
     */
    public function saveCart(OrderInterface $cart): SavedCart
    {
        $savedCart = new SavedCart();

        $em = $this->container->get('doctrine')->getManager();

        // Load product into saved cart.
        /** @var OrderItemInterface $item */
        foreach ($cart->getItems() as $item) {
            $savedItem = new SavedCartItem();
            $savedItem->setProduct($item->getVariant());
            $savedItem->setQuantity($item->getQuantity());
            $savedItem->setSavedCart($savedCart);

            $em->persist($savedItem);
        }

        $customer = $this->container->get('sylius.context.customer')->getCustomer();

        if ($customer->getUser() instanceof ShopUserInterface) {
            $savedCart->setUser($customer->getUser());
        }

        $em->persist($savedCart);
        $em->flush();

        return $savedCart;
    }

    /**
     * @param SavedCart $savedCart
     * @param bool $useCurrentCart
     *
     * @return OrderInterface
     */
    public function loadCart(SavedCart $savedCart, bool $useCurrentCart = false): OrderInterface
    {
        /** @var OrderInterface $cart */
        if ($useCurrentCart) {
            $cart = $this->container->get('sylius.context.cart')->getCart();
        } else {
            $cart = $this->container->get('sylius.factory.order')->createNew();
        }

        $factory = $this->container->get('sylius.factory.order_item');
        $modifier = $this->container->get('sylius.order_item_quantity_modifier');

        foreach ($cart->getItems() as $item) {
            $this->container->get('sylius.order_modifier')->removeFromOrder($cart, $item);
        }

        foreach ($savedCart->getSavedCartItems() as $savedItem) {
            $item = $factory->createNew();
            $item->setVariant($savedItem->getProduct());

            $modifier->modify($item, $savedItem->getQuantity());

            $cart->addItem($item);
        }

        $channel = $this->container->get('sylius.context.channel')->getChannel();
        $currency = $this->container->get('sylius.context.currency')->getCurrencyCode();
        $locale = $this->container->get('sylius.context.locale')->getLocaleCode();

        $cart->setChannel($channel);
        $cart->setCurrencyCode($currency);
        $cart->setLocaleCode($locale);

        $this->container->get('sylius.order_processing.order_processor')->process($cart);

        if ($useCurrentCart) {
            $this->container->get('sylius.repository.order')->add($cart);
        }

        return $cart;
    }
}