<?php
require_once('../config.php');

$page_title = 'Transaction Search';

?>
<!DOCTYPE html>
<html>
<head>
	<?php include '../meta.php' ?>
</head>
<body>

<div class="container">
	<?php include '../header.php' ?>

  	<form id="search" method="post" action="transaction_search_results.php" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">Amount</label>
			<div class="col-sm-5">
				<input type="number" class="form-control" id="amountMin" name="amountMin" placeholder="min">
			</div>
			<div class="col-sm-5">
				<input type="number" class="form-control" id="amountMax" name="amountMax" placeholder="max">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Transaction IDs</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="txnIds" name="txnIds" placeholder="Transaction IDs">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Order ID</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="orderId" name="orderId" placeholder="Order ID">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
					  <input type="checkbox"> Remember me
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			<input type="submit" value="Search" class="btn btn-primary btn-block btn-lg">
			</div>
		</div>
	    
	</form>

</div>

</body>
</html>