<?php
require_once('../config.php');

$page_title = 'Multicurrency';
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
<form id="checkout" method="post" action="dropin-multicurrency-checkout.php">
	<div class="row">
	  <div class="col-md-6">
	    <div class="thumbnail">
	      <img src="../images/mug1.jpg" alt="Braintree mug">
	      <div class="caption row">
	      	<div class="col-md-8">
		        <h3>Braintree Mug</h3>
		        <p class="text-muted">12oz. steel and enamel mug</p>
	        </div>
	        <div class="pull-right col-md-4">
	        	<select class="form-control" style="margin-top:20px" name="currency">
				  <option value="USD">USD $10</option>
				  <option value="AUD">AUD $12</option>
				  <option value="HKD" selected>HKD $60</option>
				  <option value="SGD">SGD $14</option>
				</select>
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
	  	<div>
	  	
		  <div id="payment-form"></div>
		  <input type="submit" value="Pay" class="btn btn-primary btn-block btn-lg">
		

		</div>
	  </div>
	</div> <!-- end div.row -->
</form>

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Note</h3>
		</div>
		<div class="panel-body">
			For multicurrency, always specify the correponding merchant account ID, which is configured in your account.
			<img class="img-responsive" src="../images/multicurrency-merchant-account-id.png" alt="Braintree Merchant Account ID">
		</div>
	</div>
</div>




<script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
<script>
$(function(){
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
      }
	});	
});
</script>

</body>
</html>
