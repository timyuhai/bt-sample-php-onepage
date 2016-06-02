<?php
require_once('../config.php');

$result = Braintree_Transaction::sale([
  'amount' => '10.00',
  'paymentMethodNonce' => $_POST['payment_method_nonce'],
  'deviceData' => $_POST['device_data'],
  'orderId' => uniqid('ORDER_'),
  'creditCard' => [
  	'expirationMonth' => $_POST['expirationMonth'],
  	'expirationYear' => $_POST['expirationYear']
  ],
  'options' => [
    'submitForSettlement' => True
  ]
]);

include('../result.php');