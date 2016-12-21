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
        try {
            $this->session->order = $this->createOrder($this->view->language, 0);

            $params = [

                'newState'      => \CoreShop\Model\Order\State::STATE_NEW,
                'newStatus'     => \CoreShop\Model\Order\State::STATUS_PENDING,
                'additional'    => [
                    'sendOrderConfirmationMail' => 'yes',
                ]

            ];

            try {
                \CoreShop\Model\Order\State::changeOrderState($this->session->order, $params);
                $this->redirect($this->getModule()->getConfirmationUrl());
            } catch(\Exception $e) {
                $this->redirect($this->getModule()->getErrorUrl($e->getMessage()));
            }

        } catch(\Exception $e ) {
            $this->redirect($this->getModule()->getErrorUrl($e->getMessage()));
        }
    }

    /**
     * @return Bankwire\Shop
     */
    public function getModule()
    {
        return parent::getModule();
    }
}
