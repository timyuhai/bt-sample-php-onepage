<?php
require_once('../config.php');

$page_title = 'Hosted Fields';
$clientToken = Braintree_ClientToken::generate();
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
	  	<h2 class="text-primary">Payment</h2>
	  	<p  class="text-muted">
	  	Pay using credit card or PayPal below.
	  	</p>
	  	<div class="alert alert-info">Testing Card Number: 4111111111111111</div>
	  	<div>
	  	<form id="checkout" method="post" action="hosted-fields-checkout.php">
	  		<div class="form-group">
		  		<div id="paypal-button"></div>
		  	</div>
	  		<div class="form-group">
	  			<label>Card Number</label>
			    <div id="card-number" class="form-control"></div>
			    <span class="payment-method-icon"></span>
			</div>
			<div class="form-group">
				<label>Expiration Date</label>
			    <div id="expiration-date" class="bt-input form-control"></div>
			</div>
			<div class="form-group">
				<label>CVV</label>
			    <div id="cvv" class="bt-input form-control"></div>
			</div>
		    <input type="submit" value="Pay" class="btn btn-primary btn-block btn-lg">
		</form>

		</div>
	  </div>
	</div>

</div>


<script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
<script>
$(function(){
	braintree.setup("<?php echo $clientToken ?>", "custom", {
		id: "checkout",
		hostedFields: {
			onFieldEvent: function (event) {
		        if (event.type === "focus") {
		          // Handle focus
		        } else if (event.type === "blur") {
		          // Handle blur
		        } else if (event.type === "fieldStateChange") {
					if (!event.isValid) {
						$('.payment-method-icon').removeClass()
						                         .addClass("payment-method-icon");
					}

					if (event.card) {
						console.log(event.card.type);
						// visa|master-card|american-express|diners-club|discover|jcb|unionpay|maestro
						$('.payment-method-icon').removeClass()
						                         .addClass("payment-method-icon " + event.card.type);
					}
		        }
		    },
			styles: {
		        // Style all elements
		        // these are not all available styles.
		        // refer to documentation for more info
		        "input": {
		          "font-size": "14px",
		          "color": "#555555",
		          "font-family": "'Helvetica Neue', Helvetica, Arial, sans-serif",
		          "font-size": "14px",
		          "font-style": "normal",
		          "font-variant": "normal",
		          "font-weight": "normal"
		        },

		        // Styling a specific field
		        ".number": {
		          // "font-family": "monospace"
		        },

		        // Styling element state
		        ":focus": {
		          "color": "blue"
		        },
		        ".valid": {
		          "color": "green"
		        },
		        ".invalid": {
		          "color": "red"
		        },

		        // Media queries
		        // Note that these apply to the iframe, not the root window.
		        "@media screen and (max-width: 700px)": {
		          "input": {
		            "font-size": "14px"
		          }
		        }
			},
			number: {
				selector: "#card-number",
		        placeholder: "Credit Card Number"
			},
			cvv: {
		        selector: "#cvv",
		        placeholder: "CVV"
			},
			expirationDate: {
		        selector: "#expiration-date",
		        placeholder: "MM/YYYY"
			}
		},
		paypal: {
			container: "paypal-button"
		},
		dataCollector: {
			kount: {environment: 'sandbox'}
		},
		onReady: function (braintreeInstance) {
	      var form = document.getElementById('checkout');
	      var deviceDataInput = form['device_data'];

	      if (deviceDataInput == null) {
	        deviceDataInput = document.createElement('input');
	        deviceDataInput.name = 'device_data';
	        deviceDataInput.hidden = true;
	        form.appendChild(deviceDataInput);
	      }

	      deviceDataInput.value = braintreeInstance.deviceData;
	    }
	});	// end of braintree.setup
});
</script>

</body>
</html>
