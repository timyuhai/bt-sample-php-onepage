<?php
require_once('../config.php');

$page_title = 'Drop-in UI';
$clientToken = Braintree_ClientToken::generate();
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../meta.php' ?>
<style>
#modal {
  position: absolute;
  top: 0;
  left: 0;
  display: flex;
  align-items: center;
  height: 100vh;
  width: 100vw;
  z-index: 100;
}

.bt-modal-frame {
  height: 480px;
  width: 440px;
  margin: auto;
  background-color: #eee;
  z-index: 2;
  border-radius: 6px;
}

.bt-modal-body {
  height: 400px;
  margin: 0 20px;
  background-color: white;
  border: 1px solid lightgray;
}

.bt-modal-header, .bt-modal-footer {
  height: 40px;
  text-align: center;
  line-height: 40px;
}

.bt-mask {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-color: black;
  opacity: 0.8;
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
	  	<div class="alert alert-info">Liability Shifted: 4000000000000002</div>
	  	<div class="alert alert-info">Liability not Shifted: 4000000000000028</div>
	  	<div>
	  	<form id="checkout" method="post" action="dropin-checkout.php">
		  <label for="card-number">Card Number</label>
            <div class="form-control hosted-field" id="card-number"></div>

            <label for="cvv">CVV</label>
            <div class="form-control hosted-field" id="cvv"></div>

            <label for="expiration-date">Expiration Date</label>
            <div class="form-control hosted-field" id="expiration-date"></div>

            <input type="hidden" name="payment_method_nonce">
            <br>
		  <input type="submit" value="Pay" class="btn btn-primary btn-block btn-lg">
		</form>

		</div>
	  </div>
	</div>

</div>
<div id="modal" class="hidden">
  <div class="bt-mask"></div>
  <div class="bt-modal-frame">
    <div class="bt-modal-header">
      <div class="header-text">Authentication</div>
    </div>
    <div class="bt-modal-body"></div>
    <div class="bt-modal-footer"><a id="text-close" href="#">Cancel</a></div>
  </div>
</div>

<script src="https://js.braintreegateway.com/web/3.0.2/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.0.2/js/hosted-fields.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.0.2/js/three-d-secure.min.js"></script>

<script>
var form = document.querySelector('#checkout');
var submit = document.querySelector('input[type="submit"]');
var threeDSecure;

var modal = document.getElementById('modal');
var bankFrame = document.querySelector('.bt-modal-body');
var closeFrame = document.getElementById('text-close');

function addFrame(err, iframe) {
  bankFrame.appendChild(iframe);
  modal.classList.remove('hidden');
}

function removeFrame() {
  var iframe = bankFrame.querySelector('iframe');
  modal.classList.add('hidden');
  iframe.parentNode.removeChild(iframe);
}

$(function(){

    braintree.client.create({
      authorization: "<?php echo $clientToken ?>"
    }, function (clientErr, clientInstance) {
      if (clientErr) {
        // Handle error in client creation
        return;
      }

      braintree.hostedFields.create({
        client: clientInstance,
        styles: {
          'input': {
            'font-size': '14pt'
          },
          'input.invalid': {
            'color': 'red'
          },
          'input.valid': {
            'color': 'green'
          }
        },
        fields: {
          number: {
            selector: '#card-number',
            placeholder: '4111 1111 1111 1111'
          },
          cvv: {
            selector: '#cvv',
            placeholder: '123'
          },
          expirationDate: {
            selector: '#expiration-date',
            placeholder: '10 / 2019'
          }
        }
      }, function (hostedFieldsErr, hostedFieldsInstance) {
        if (hostedFieldsErr) {
          // Handle error in Hosted Fields creation
          return;
        }

        submit.removeAttribute('disabled');
        form.addEventListener('submit', function (event) {
          event.preventDefault();

          hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
            if (tokenizeErr) {
              // Handle error in Hosted Fields tokenization
              return;
            }

            // Put `payload.nonce` into the `payment-method-nonce` input, and then
            // submit the form. Alternatively, you could send the nonce to your server
            // with AJAX.

			threeDSecure.verifyCard({
			  amount: 10,
			  nonce: payload.nonce,
			  // addFrame and removeFrame functions here
  			  addFrame: addFrame,
      			  removeFrame: removeFrame
			}, function (error, response) {
			  if (error) {
			    // Handle error
			    console.log(error);
			    return;
			  }

			  console.log('nonce' + response.nonce);
			  // Submit response.nonce to server
			  document.querySelector('input[name="payment_method_nonce"]').value = response.nonce;
            		  form.submit();
			});          
			  
          });
        }, false);

      });

      braintree.threeDSecure.create({
	    client: clientInstance
	  }, function (threeDSecureErr, threeDSecureInstance) {
	    if (threeDSecureErr) {
	      console.log(threeDSecureErr);
	      return;
	    }

	    threeDSecure = threeDSecureInstance;
	  });
    });
});
</script>

</body>
</html>
