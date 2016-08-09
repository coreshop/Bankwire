<?php
/**
 * Bankwire
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2016 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

use CoreShop\Controller\Action\Payment;
use CoreShop\Tool;

/**
 * Class Bankwire_PaymentController
 */
class Bankwire_PaymentController extends Payment
{
    /**
     * User accepted Bankwire Payment -> createOrder
     */
    public function paymentAction()
    {
        //DoPayment
        //$this->session->order = $this->getModule()->createOrder($this->cart, \CoreShop\Model\Order\State::getById(\CoreShop\Model\Configuration::get("SYSTEM.ORDERSTATE.BANKWIRE")), 0, $this->view->language);

        $this->session->order = $this->cart->createOrder(\CoreShop\Model\Order\State::getById(\CoreShop\Model\Configuration::get("SYSTEM.ORDERSTATE.BANKWIRE")), $this->getModule(), 0, $this->view->language);
        
        $this->redirect($this->getModule()->getConfirmationUrl());
    }

    /**
     * @return Bankwire\Shop
     */
    public function getModule()
    {
        return parent::getModule();
    }
}
