<?php
require_once('../config.php');

$page_title = 'Drop-in UI';
$clientToken = Braintree_ClientToken::generate();
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../meta.php' ?>
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
	  	<h2 class="text-primary">Payment</h2>
	  	<p  class="text-muted">
	  	Pay using credit card or PayPal below.
	  	</p>
	  	<div class="alert alert-info">Testing Card Number: 4111111111111111</div>
	  	<div class="alert alert-info">Liability Shifted: 4000000000000002</div>
	  	<div class="alert alert-info">Liability not Shifted: 4000000000000028</div>
	  	<div>
	  	<form id="checkout" method="post" action="dropin-checkout.php">
		  <div id="payment-form"></div>
		  <input type="submit" value="Pay" class="btn btn-primary btn-block btn-lg">
		</form>

		</div>
	  </div>
	</div>

</div>


<script src="https://js.braintreegateway.com/js/braintree-2.26.0.min.js"></script>
<script>
$(function(){
	var client = new braintree.api.Client({
		clientToken: '<?php echo $clientToken ?>'
	});

	braintree.setup("<?php echo $clientToken ?>", "dropin", {
	  container: "payment-form",
	  dataCollector: {
        kount: {environment: 'sandbox'}
      },
      onReady: function (braintreeInstance) {
        var form = document.getElementById('payment-form');
        var deviceDataInput = form['device_data'];

        if (deviceDataInput == null) {
          deviceDataInput = document.createElement('input');
          deviceDataInput.name = 'device_data';
          deviceDataInput.hidden = true;
          form.appendChild(deviceDataInput);
        }

        deviceDataInput.value = braintreeInstance.deviceData;
      },
      onPaymentMethodReceived: function (payload) {
      	if  (payload.type == 'CreditCard') {
	      	client.verify3DS({
			  amount: 10,
			  creditCard: payload.nonce
			}, function (error, response) {
			  if (!error) {
			  		console.log(JSON.stringify(response));
			  		$('<input>', {
					    type: 'text',
					    id: 'foo',
					    name: 'payment_method_nonce',
					    value: response.nonce
					}).appendTo('form');

					$('#checkout').submit();
	            } else {
	                var p = document.createElement("p");
	                p.innerHTML = error.message;
	                document.body.appendChild(p);
	            }
			});
      	}
      }
	});	
});
</script>

</body>
</html>
