<?php
require_once('../config.php');

try {
$currency_array = [
	'USD' => '10.00',
	'SGD' => '14.00',
	'AUD' => '12.00',
	'HKD' => '60.00'
];

$result = Braintree_Transaction::sale([
  'amount' => $currency_array[$_POST['currency']],
  'paymentMethodNonce' => $_POST['payment_method_nonce'],
  'deviceData' => $_POST['device_data'],
  'merchantAccountId' => "braintree{$_POST['currency']}",
  'orderId' => uniqid('ORDER_'),
  'options' => [
    'submitForSettlement' => True
  ]
]);

} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
	echo '<pre>';
	var_dump($e);
	echo '</pre>';
}

include('../result.php');