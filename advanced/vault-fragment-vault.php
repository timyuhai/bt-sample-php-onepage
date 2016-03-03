
<?php
require_once('../config.php');
require_once('../common/util.php');

// var_dump($bt_customer->paymentMethods);
?>
	  	<p  class="text-muted">
	  	Choose a payment method below.
	  	</p>

	  	<div>
	  	<form id="checkout" method="post" action="vault-checkout.php">
		  	<? foreach ($bt_customer->paymentMethods as $pm): ?>
				<div class="radio">
					<label>
						<input type="radio" name="payment_method_token" id="payment_method_token" value="<? echo $pm->token ?>" <? echo $pm->isDefault() ? 'checked':''?>>
							<img src="<? echo $pm->imageUrl ?>" class="" alt="Responsive image" style="height: 30px"/>&nbsp;
							<? 
							if (is_a($pm, 'Braintree\CreditCard')) {
								include 'vault-fragment-credit-card.php';
							}
							elseif (is_a($pm, 'Braintree\PayPalAccount')) {
								include 'vault-fragment-paypal.php';
							}
							?>
						</input>
					</label>
				</div>

			<? endforeach ?>

		    <input type="submit" value="Pay" class="btn btn-primary btn-block btn-lg">
		</form>

		</div>

<script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
<script>
$(function(){
	// collect device data
});
</script>
