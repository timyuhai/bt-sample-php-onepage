<?php

require_once '../common/user.php';
require_once '../common/util.php';

Util::destroy_session();

if (isset($_POST['email']) && !empty($_POST['email'])) {
	$user = User::find(trim($_POST['email']));

	if (empty($user)) {
		Util::flash_error_message('Email not found');
		header("Location: {$_SERVER['HTTP_REFERER']}");
		return;
	}

	Util::set_current_user($user);
	header('Location: vault.php');
} else {
	Util::flash_error_message('Please provide email address');
	header("Location: {$_SERVER['HTTP_REFERER']}");
}

