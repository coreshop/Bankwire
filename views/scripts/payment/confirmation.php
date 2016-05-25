<p>
    <?php
        echo sprintf($this->translate("Your Order has been submitted. You have choosen to by with Bankwire.<br/>Your Order Number is %s, please follow the instructions:"), $this->order->getOrderNumber())
    ?>
</p>
<p><?php echo html_entity_decode(\CoreShop\Model\Configuration::get("BANKWIRE.TEXT." . strtoupper($this->language)))?></p>