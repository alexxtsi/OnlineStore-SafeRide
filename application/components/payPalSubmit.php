<?php
// checkout.php
$payNowButtonUrl = 'https://www.sandbox.paypal.com/cgi-bin/websc';
$userId = 315; // id текущего пользователя

$receiverEmail = 'sb-vbha473030483@business.example.com'; //email получателя платежа(на него зарегестрирован paypal аккаунт) 
$productId = 1;
$itemName = 'Shopping cart';    // название продукта
$amount = '1.0'; // цена продукта(за 1 шт.)
$quantity = 3;    // количество

$returnUrl = 'http://localhost/SafeRideStore/payment_success.php';
$customData = ['user_id' => $userId, 'product_id' => $productId];
?>

<form action="<?php echo $payNowButtonUrl; ?>" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?= $receiverEmail; ?>">
    <input id="paypalItemName" type="hidden" name="item_name" value="<?= $itemName; ?>">
    <input id="paypalAmmount" type="hidden" name="amount" value="<?= $amount; ?>">
    <input type="hidden" name="no_shipping" value="0">
    <input type="hidden" name="return" value="<?= $returnUrl; ?>">

    <input type="hidden" name="custom" value="<?= json_encode($customData); ?>">

    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="US">
    <input type="hidden" name="bn" value="PP-BuyNowBF">

    <button type="submit">
        Pay Now
    </button>
</form>

