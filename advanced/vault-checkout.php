<?php
require_once('../config.php');
require_once('../common/user.php');
require_once('../common/util.php');

$user = Util::current_user();

$sale_params = [
	'amount' => '10.00',
	'deviceData' => $_POST['device_data'],
	'orderId' => uniqid('ORDER_'),
];

if (isset($user) && empty($user->bt_customer_id)) {
	// new user
	$sale_params = array_merge($sale_params, [
		'customer' => [
			'email' => $user->email
		]
	]);
} elseif (isset($user) && !empty($user->bt_customer_id)) {
	// return user
	$sale_params = array_merge($sale_params, [
		'customerId' => $user->bt_customer_id
	]);
} else {
	// guest checkout (no user)
	// No customer information needed
}

$sale_params = array_merge($sale_params, [
		'options' => [
		    'submitForSettlement' => True,
		    'storeInVaultOnSuccess' => isset($user) && $_POST['is_save'] === 'yes' // for guest, we do not want to save payment method
		]
	]);

if (isset($_POST['payment_method_nonce']) && !empty ($_POST['payment_method_nonce']))
	$sale_params = array_merge($sale_params, [
			'paymentMethodNonce' => $_POST['payment_method_nonce']
		]);
elseif (isset($_POST['payment_method_token']) && !empty ($_POST['payment_method_token']))
	$sale_params = array_merge($sale_params, [
			'paymentMethodToken' => $_POST['payment_method_token']
		]);
else {
	// fatal error
	Util::flash_error_message('Missing nonce or token');
	header("Location: {$_SERVER['HTTP_REFERER']}");
}

$result = Braintree_Transaction::sale($sale_params);

if (isset($user) && empty($user->bt_customer_id)) {
	// save the generated customer id
	if ($result->success && !empty($result->transaction->customerDetails->id)) {
		$user->bt_customer_id = $result->transaction->customerDetails->id;
		User::update($user);
	}
}

include('vault-result.php');