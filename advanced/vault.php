
<?php
require_once('../config.php');
require_once('../common/util.php');

$page_title = 'Vault Payment';

$user = Util::current_user();

function get_bt_customer($user) {
	if (isset($user) && !empty($user->bt_customer_id)) {
		try {
			return Braintree_Customer::find($user->bt_customer_id);
		} catch (Braintree_Exception_NotFound $e) {
			// customer does not exist
			$user->bt_customer_id = NULL;
			$user = User::update($user);
		}
	}

	return NULL;
}

$bt_customer = get_bt_customer($user);

function displayPaymentPage($user, $bt_customer) {
	if (!isset($_GET['new']) && isset($bt_customer)) {
		if (count($bt_customer->paymentMethods) > 0) {
			include 'vault-fragment-vault.php';
			return;
		}
	}
	
	include 'vault-fragment-hosted-fields.php';
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../meta.php' ?>
<style>
.bt-input {
/*	
	height: 34px;	
	background: #fff;
	border: solid 1px #ccc;
	box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
	box-sizing: border-box;
	padding-bottom: 6px;
	padding-left: 12px;
	padding-right: 12px;
	padding-top: 6px;
*/
}

#card-number {
  -webkit-transition: border-color 160ms;
  transition: border-color 160ms;
}

.braintree-hosted-fields-focused {
  border-color: blue;
}

.braintree-hosted-fields-invalid {
  border-color: tomato;
}

.braintree-hosted-fields-valid {
  border-color: limegreen;
}

.payment-method-icon {
    background-repeat: no-repeat;
    background-size: 86px auto;
    height: 28px;
    width: 44px;
    display: block;
    margin-top: -31px;
    position: absolute;
    left: auto;
    right: 24px;
    text-indent: -15984px;
}

.visa {
    background-image: url(https://assets.braintreegateway.com/dropin/1.4.0/images/2x-sf9a66b4f5a.png);
    background-position: 0px -184px;
}

.master-card {
    background-image: url(https://assets.braintreegateway.com/dropin/1.4.0/images/2x-sf9a66b4f5a.png);
    background-position: 0px -128px;
}

.american-express {
    background-image: url(https://assets.braintreegateway.com/dropin/1.4.0/images/2x-sf9a66b4f5a.png);
    background-position: 0px -72px;
}
</style>
</head>
<body>
<div class="container">
	<?php include '../header.php' ?>

	<div class="row">
	  <div class="col-md-6">
	    <div class="thumbnail">
	      <img src="../images/mug1.jpg" alt="Braintree mug">
	      <div class="caption row">
	      	<div class="col-md-9">
		        <h3>Braintree Mug</h3>
		        <p class="text-muted">12oz. steel and enamel mug</p>
	        </div>
	        <div class="pull-right col-md-3">
	        		<h1 class="text-primary">$10</h1>
	        </div>
	      </div>
	    </div>
	  </div>

	  <div class="col-md-6">
	  	<h2 class="text-primary">Payment - <? echo "User {$user->email}" ?></h2>
	  	<? if (isset($bt_customer) && count($bt_customer->paymentMethods) > 0): ?>
	  	<div class="text-center" style="margin: 30px"><a href="vault.php<? echo isset($_GET['new'])? '' : '?new' ?>">Change Payment Method</a></div>
		<? endif ?>
	  	<? displayPaymentPage($user, $bt_customer) ?>
	  </div>
	</div><!-- end row -->


	<hr>

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Current User Info</h3>
		</div>
		<div class="panel-body">
			<? echo "{$user->email} - {$user->bt_customer_id}"?>
		</div>
	</div>

</div><!-- end of container -->


</body>
</html>
