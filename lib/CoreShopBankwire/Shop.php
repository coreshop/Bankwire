<?php

namespace CoreShopBankwire;

use CoreShop\Model\Cart;
use CoreShop\Model\Order;
use CoreShop\Model\Plugin\Payment as CorePayment;
use CoreShop\Plugin as CorePlugin;
use CoreShop\Tool;

class Shop extends CorePayment
{
    public static $install;

    /**
     * Attach Events for CoreShop
     *
     * @throws \Zend_EventManager_Exception_InvalidArgumentException
     */
    public function attachEvents()
    {
        CorePlugin::getEventManager()->attach("payment.getProvider", function($e) {
            return $this;
        });

        CorePlugin::getEventManager()->attach('controller.init', function($e) {
            $controller = $e->getTarget();

            $controller->view->setScriptPath(
                array_merge(
                    $controller->view->getScriptPaths(),
                    array(
                        PIMCORE_PLUGINS_PATH . '/CoreShopBankwire/views/scripts/',
                        CORESHOP_TEMPLATE_PATH . '/views/scripts/coreshopbankwire/'
                    )
                )
            );
        });
    }

    /**
     * Get Payment Provider Name
     *
     * @return string
     */
    public function getName()
    {
        return "Bankwire";
    }

    /**
     * Get Payment Provider Description
     *
     * @return string
     */
    public function getDescription()
    {
        return "";
    }

    /**
     * Get Payment Provider Image
     *
     * @return string
     */
    public function getImage()
    {
        return "/plugins/CoreShopBankwire/static/img/bankwire.gif";
    }

    /**
     * Get Payment Provider Identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return "payment_bankwire";
    }

    /**
     * Get Payment Fee
     *
     * @param Cart $cart
     * @return int
     */
    public function getPaymentFee(Cart $cart)
    {
        return 0;
    }

    /**
     * Process CoreShop Payment
     *
     * @param Order $order
     * @return string
     */
    public function processPayment(Order $order)
    {
        $coreShopPayment = $order->createPayment($this, $order->getTotal());

        $this->validateOrder($coreShopPayment, $order, \CoreShop\Model\OrderState::getById(\CoreShop\Config::getValue("ORDERSTATE.BANKWIRE")));

        Tool::prepareCart();
        $session = Tool::getSession();

        unset($session->order);
        unset($session->cart);
        unset($session->cartId);

        return "coreshopbankwire/bankwire";
    }
}