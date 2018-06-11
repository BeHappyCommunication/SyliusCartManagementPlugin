<?php

namespace BeHappy\SyliusCartManagementPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AccountMenuListener
{
    public function addAccountMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        $menu
            ->addChild('saved_cart.index', ['route' => 'behappy_cart_management_plugin.account.saved_cart_list'])
            ->setLabel('behappy.cart_management.account.my_saved_carts')
            ->setLabelAttribute('icon', 'save')
        ;
    }
}