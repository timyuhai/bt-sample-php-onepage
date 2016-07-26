<?php 
session_start();
$page_title = 'Vault';
?>

<!DOCTYPE html>
<html>
<head>
<? include '../meta.php' ?>
</head>
<body>

<div class="container">
<? include '../header.php' ?>

<? Util::error_message() ?>

<div class="row">
<div class="col-md-6">
<div class="jumbotron">
  <h3>New User</h3>
  <form name="new_user" id="new_user" class="form" method="post" action="vault-new-user.php">
  	<div class="form-group">
		<label>Email Address</label>
	    <input class="form-control" type="email" id="email" name="email"></input>
	</div>
	<div class="form-group">
  	  <input type="submit" class="btn btn-primary btn-lg" value="Register"></input>
	</div>

  </form>
</div>
</div><!-- end col 1 -->

<div class="col-md-6">
<div class="jumbotron">
  <h3>Already Registered? Login</h3>
  <form name="old_user" id="old_user" class="form" method="post" action="vault-login.php">
  	<div class="form-group">
		<label>Email Address</label>
	    <input class="form-control" type="email" id="email" name="email"></input>
	</div>
	<div class="form-group">
  	  <input type="submit" class="btn btn-primary btn-lg" value="Login"></input>
	</div>

  </form>
</div>
</div><!-- end col 2 -->

</div><!-- end row -->

</div>

</body>
</html>