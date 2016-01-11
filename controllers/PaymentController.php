<?php

use CoreShop\Controller\Action\Payment;
use Pimcore\Model\Object\CoreShopPayment;

use CoreShop\Tool;

class CoreShopBankwire_PaymentController extends Payment
{
    /**
     * User accepted Bankwire Payment -> createOrder
     */
    public function paymentAction()
    {
        //DoPayment
        $this->session->order = $this->getModule()->createOrder($this->cart, \CoreShop\Model\OrderState::getById(\CoreShop\Config::getValue("ORDERSTATE.BANKWIRE")), $this->cart->getTotal(), $this->view->language);

        $this->redirect($this->getModule()->getConfirmationUrl());
    }

    /**
     * @return CoreShopBankwire\Shop
     */
    public function getModule()
    {
        return parent::getModule();
    }
}
