
<?php
require_once('../config.php');
require_once('../common/util.php');

$clientToken = Braintree_ClientToken::generate();
?>


	  	<p  class="text-muted">
	  	Pay using credit card or PayPal below.
	  	</p>
	  	<div class="alert alert-info">Testing Card Number: 4111111111111111</div>
	  	<div>
	  	<form id="checkout" method="post" action="vault-checkout.php">
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
			<div class="checkbox">
			  <label>
			    <input type="checkbox" value="yes" name="is_save" checked>
			    <p class="text-primary"><strong>Save payment method.</strong></p>
			    </input>
			  </label>
			</div>

		    <input type="submit" value="Pay" class="btn btn-primary btn-block btn-lg">
		</form>

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
