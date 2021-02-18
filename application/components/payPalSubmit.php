<?php

use application\components\Cart;

$payNowUrl = 'https://www.sandbox.paypal.com/cgi-bin/websc';
$userName = $_SESSION['userName']; //user name

$receiverEmail = 'sb-vbha473030483@business.example.com'; //payment reciver email 
$cartId = 1;
$itemName = 'Shopping cart';    // product name
$amount = Cart::TotalPrice(); //price
$quantity = 1;

$returnUrl = 'http://localhost/SafeRideStore';
$cancelUrl = 'http://localhost/SafeRideStore';
$notifyUrl = 'http://localhost/SafeRideStore/notify';


?>
<form id="payForm" action=<?= $payNowUrl; ?> method="post" target="_top">
    <input type="hidden" id="payNowUrl" name="payNowUrl" value='<?= $payNowUrl; ?>'>
    <input type='hidden' name='business' value='<?= $receiverEmail; ?>'>
    <input type='hidden' name='item_name' value='<?= $itemName; ?>'>
    <input type='hidden' name='item_number' value='<?= $userName; ?> '>
    <input type='hidden' name='amount' id="totalPrice" value='<?= $amount; ?>'>
    <input type='hidden' name='no_shipping' value='1'>
    <input type='hidden' name='currency_code' value='USD'>
    <input type='hidden' name='notify_url' value='<?= $notifyUrl; ?>'>
    <input type='hidden' name='cancel_return' value='<?= $cancelUrl; ?>'>
    <input type='hidden' name='return' value='<?= $returnUrl; ?>'>
    <input type="hidden" name="cmd" value="_xclick">
    <input class="btn btn-primary ml-5 pay" type="submit" name="pay_now" id="pay_now" Value="Pay Now">
</form>