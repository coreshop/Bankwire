<?php
/**
 * CoreShopBankwire
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015 Dominik Pfaffenbauer (http://dominik.pfaffenbauer.at)
 * @license    http://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

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
        $this->session->order = $this->getModule()->createOrder($this->cart, \CoreShop\Model\OrderState::getById(\CoreShop\Model\Configuration::get("SYSTEM.ORDERSTATE.BANKWIRE")), $this->cart->getTotal(), $this->view->language);

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