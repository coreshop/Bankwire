<div class="container shop checkout checkout-step-5">
    <?=$this->partial("coreshop/helper/order-steps.php", array("step" => 5));?>

    <p>Ihre Bestellung wurde aufgegeben. Bitte überweißen Sie <?=\CoreShop\Tool::formatPrice($this->order->getTotal())?> an XYZ.</p>
    <p>Als Zahlungsreferenz geben Sie <?=$this->order->getOrderNumber()?> an</p>

</div>