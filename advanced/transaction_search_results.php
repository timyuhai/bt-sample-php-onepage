<?php
require_once('../config.php');

$page_title = 'Transaction Search';

function rangeParam($range, $min, $max) {
	if (isset($min) && isset($max))
		return [$range->between($min, $max)];

	if (isset($min) && !isset($max))
		return [$range->greaterThanOrEqualTo($min)];

	if (!isset($min) && isset($max))
		return [$range->lessThanOrEqualTo($max)];

	return [];
}

function valueParam($p, $val) {
	if (isset($val))
		return [$p->is($val)];

	return [];
}

function multiValueParam($p, $val) {
	if (isset($val)) {
		return [$p->in(explode(',', preg_replace('/\s+/', '', $val)))];
	}
	return [];
}

$search_params = [];

$amount_param = rangeParam(Braintree_TransactionSearch::amount(), $_POST['amountMin'], $_POST['amountMax']);

$tnxIds_param = multiValueParam(Braintree_TransactionSearch::ids(), $_POST['txnIds']);
$orderId_param = valueParam(Braintree_TransactionSearch::orderId(), $_POST['orderId']);

$search_params = array_merge($search_params, 
	$amount_param,
	$tnxIds_param,
	$orderId_param);

$collection = Braintree_Transaction::search($search_params);


?>
<!DOCTYPE html>
<html>
<head>
	<?php include '../meta.php' ?>
</head>
<body>

<div class='container'>
<?php include '../header.php' ?>

<table class='table'>
	<tr>
		<th>Transaction ID</th>
		<th>Creation Date</th>
		<th>Amount</th>
		<th>Status</th>
		<th>Credit Card</th>
	</tr>
	<? foreach ($collection as $txn): ?>
	<tr>
		<td><? echo $txn->id ?></td>
		<td><? echo $txn->createdAt->format('Y-m-d H:i:s'); ?></td>
		<td><? echo "{$txn->currencyIsoCode} {$txn->amount}" ?></td>
		<td><? echo $txn->status ?></td>
		<td><? 
		if ($txn->paymentInstrumentType == 'credit_card') 
			echo "{$txn->creditCardDetails->cardType} - {$txn->creditCardDetails->last4}";
		elseif ($txn->paymentInstrumentType == 'paypal_account')
			echo "{$txn->paypalDetails->payerEmail}";
		else
			echo $txn->paymentInstrumentType;
		?></td>
	</tr>
	<? endforeach; ?>
</table>

<div>
<a class="btn btn-primary btn-block btn-lg" href="<? echo $_SERVER['HTTP_REFERER'] ?>">Start Again</a>
</div>
<br>

<pre>
<?
var_dump($collection);
?>
</pre>
</div>
</body>
</html>