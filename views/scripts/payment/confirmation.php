<div class="container shop checkout checkout-step-5">
    <?=$this->partial("coreshop/helper/order-steps.php", array("step" => 5));?>

    <p>
        <?php
        echo sprintf($this->translate("Your Order has been submitted. You have choosen to by with Bankwire.<br/>Your Order Number is %s, please follow the instructions:"), $this->order->getOrderNumber())
        ?>
    </p>
    <p><?php echo \CoreShop\Model\Configuration::get("BANKWIRE.TEXT." . strtoupper($this->language))?></p>
</div>