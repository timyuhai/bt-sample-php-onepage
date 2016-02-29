<?php
  function isClassActive($url_key) {
  	$path_only = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  	// echo $path_only;
  	// echo "/^/" . $url_key . "/";
  	// echo preg_match("/^\/" . $url_key . "/", $path_only);
  	echo preg_match("/^\/" . $url_key . "/", $path_only) ? 'active' : '';
  }
?>
	<header>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="/">Braintree Samples</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      	<li class="dropdown <? isClassActive('basic'); ?>">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Basic <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="/basic/dropin.php">Drop-in UI</a></li>
	            <li><a href="/basic/hosted-fields.php">Hosted Fields</a></li>
	            <li><a href="/basic/dropin-multicurrency.php">Multi-currency</a></li>
	          </ul>
	        </li>
	        <li class="dropdown <? isClassActive('advanced'); ?>">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Advanced <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="/advanced/transaction_search.php">Transaction Search</a></li>
	          </ul>
	        </li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PayPal <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">One-time Checkout</a></li>
	            <li><a href="#">Vault Flow</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
	        <li><a href="#">Recurring</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	</header>

	<h1 class="text-primary"><? echo $page_title; ?></h1>
	<hr>