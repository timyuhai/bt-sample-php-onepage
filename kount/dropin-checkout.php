<?php
require_once('../config.php');

$result = Braintree_Transaction::sale([
  'amount' => '10.00',
  'paymentMethodNonce' => $_POST['payment_method_nonce'],
  'deviceData' => $_POST['device_data'],
  'orderId' => uniqid('ORDER_'),
  'options' => [
    'submitForSettlement' => True
  ],
  'customFields' => [
  	'fraud_site_id' => 'BT_TEST',
  	'product' => 'fraud'
  ]
]);

include('../result.php');