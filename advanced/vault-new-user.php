<?php

require_once '../common/user.php';
require_once '../common/util.php';

session_unset();

if (isset($_POST['email']) && !empty($_POST['email'])) {
	$user = new User(trim($_POST['email']));
	$user = User::create($user);

	Util::set_current_user($user);
	header('Location: vault.php');
} else {
	Util::flash_error_message('Please provide email address');
	header("Location: {$_SERVER['HTTP_REFERER']}");
}

