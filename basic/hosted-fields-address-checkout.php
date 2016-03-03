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
  'billing' => [
  	'firstName' => $_POST['first_name'],
    'lastName' => $_POST['last_name'],
    'company' => $_POST['company'],
    'streetAddress' => $_POST['street1'],
    'extendedAddress' => $_POST['street2'],
    'locality' => $_POST['city'],
    'region' => $_POST['state'],
    'postalCode' => $_POST['postal'],
    'countryCodeAlpha2' => $_POST['country']
  ],
  'shipping' => [
    'firstName' => $_POST['first_name'],
    'lastName' => $_POST['last_name'],
    'company' => $_POST['company'],
    'streetAddress' => $_POST['street1'],
    'extendedAddress' => $_POST['street2'],
    'locality' => $_POST['city'],
    'region' => $_POST['state'],
    'postalCode' => $_POST['postal'],
    'countryCodeAlpha2' => $_POST['country']
  ]
]);

include('../result.php');