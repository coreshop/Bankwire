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

namespace Bankwire;

use CoreShop\Model\Cart;
use CoreShop\Model\Plugin\Payment as CorePayment;
use CoreShop\Plugin as CorePlugin;

/**
 * Class Shop
 * @package Bankwire
 */
class Shop extends CorePayment
{
    /**
     * Attach Events for CoreShop
     *
     * @throws \Zend_EventManager_Exception_InvalidArgumentException
     */
    public function attachEvents()
    {
        \Pimcore::getEventManager()->attach("coreshop.payment.getProvider", function ($e) {
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
        return "/plugins/Bankwire/static/img/bankwire.jpg";
    }

    /**
     * Get Payment Provider Identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return "Bankwire";
    }

    /**
     * Process Validation for Payment
     *
     * @param Cart $cart
     * @return mixed
     */
    public function process(Cart $cart)
    {
        return $this->getProcessValidationUrl();
    }

    /**
     * Processes the Payment async, this method returns the process module, controller, action
     *
     * @param Cart $cart
     *
     * @return array('module', 'controller', 'action')
     */
    public function processAsync(Cart $cart)
    {
        return [
            'module' => $this->getIdentifier(),
            'controller' => 'payment',
            'action' => 'validate'
        ];
    }


    /**
     * Get url for confirmation link
     *
     * @param boolean $isOpc
     *
     * @return string
     */
    public function getConfirmationUrl($isOpc = false)
    {
        return $this->url($this->getIdentifier(), 'confirmation');
    }

    /**
     * get url for validation link
     *
     * @param boolean $isOpc
     *
     * @return string
     */
    public function getProcessValidationUrl($isOpc = false)
    {
        return $this->url($this->getIdentifier(), 'validate');
    }

    /**
     * get url payment link
     *
     * @param boolean $isOpc
     *
     * @return string
     */
    public function getPaymentUrl($isOpc = false)
    {
        return $this->url($this->getIdentifier(), 'payment');
    }
}
