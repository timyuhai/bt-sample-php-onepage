<!DOCTYPE html>
<html>
<head>
<?php include 'meta.php' ?>
</head>
<body>
<div class="container">
<?php include 'header.php' ?>

<div>
<? if ($result->success): ?>
<div class="alert alert-success"><b>Transaction Successful</b></div>
<table class="table">
	<tr>
		<th scope="row">Transaction ID</th>
		<td><? echo $result->transaction->id ?></td>
	</tr>
	<tr>
		<th scope="row">Transaction Status</th>
		<td><? echo $result->transaction->status ?></td>
	</tr>
	<tr>
		<th scope="row">Amount</th>
		<td><? print "{$result->transaction->currencyIsoCode} {$result->transaction->amount}" ?></td>
	</tr>
</table>
<? else: ?>
<div class="alert alert-danger"><b>Transaction Failed:</b> <br> <? echo $result->message ?></div>
<? endif ?>
</div>

<div>
<a class="btn btn-primary btn-block btn-lg" href="<? echo $_SERVER['HTTP_REFERER'] ?>">Start Again</a>
</div>
<br>
<pre>
<?
var_dump($result);
?>
</pre>
</div>
</body>
</html>

