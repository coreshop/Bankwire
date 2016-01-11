<?php

namespace CoreShopBankwire;

use CoreShop\Model\Cart;
use CoreShop\Model\Plugin\Payment as CorePayment;
use CoreShop\Plugin as CorePlugin;
use CoreShop\Tool;

class Shop extends CorePayment
{
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
        return "CoreShopBankwire";
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
     * Process Validation for Payment
     *
     * @param Cart $cart
     * @return mixed
     */
    public function process(Cart $cart) {
        return $this->getProcessValidationUrl();
    }

    public function processPaymentReturn() {

    }

    /**
     * Get url for confirmation link
     *
     * @return string
     */
    public function getConfirmationUrl() {
        return $this->url($this->getIdentifier(), 'confirmation');
    }

    /**
     * get url for validation link
     *
     * @return string
     */
    public function getProcessValidationUrl() {
        return $this->url($this->getIdentifier(), 'validate');
    }

    /**
     * get url payment link
     *
     * @return string
     */
    public function getPaymentUrl() {
        return $this->url($this->getIdentifier(), 'payment');
    }
}