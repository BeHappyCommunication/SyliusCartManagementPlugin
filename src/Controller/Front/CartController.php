<?php

namespace BeHappy\SyliusCartManagementPlugin\Controller\Front;

use BeHappy\SyliusCartManagementPlugin\Entity\SavedCart;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CartController
 * @package BeHappy\SyliusCartManagementPlugin\Controller\Front
 */
class CartController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function saveAction()
    {
        $cart = $this->get('sylius.context.cart')->getCart();
        $service = $this->get('behappy_cart_management_plugin.service.cart');

        if ($service->saveCart($cart)) {
            $this->addFlash('success', 'Cart saved.');
        }

        return $this->redirectToRoute('sylius_shop_homepage');
    }

    /**
     * @param string $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loadAction(string $token)
    {
        $savedCart = $this->get('behappy_cart_management_plugin.repository.saved_cart')->findByToken($token);

        if (!$savedCart instanceof SavedCart) {
            throw new NotFoundHttpException();
        }

        // Fetch current cart and current customer.
        $current = $this->get('sylius.context.cart')->getCart();
        $customer = $this->get('sylius.context.customer')->getCustomer();

        // Load target cart.
        /** @var OrderInterface $cart */
        $this->get('behappy_cart_management_plugin.service.cart')->loadCart($savedCart, true);

        $this->addFlash('success', $this->get('translator')->trans('behappy.cart_management.action.load.success'));

        return $this->redirectToRoute('sylius_shop_cart_summary');
    }
}