<?php

require_once 'user.php';

class Util {
	public static function error_message() {
		$error = $_SESSION['error'];
		if (isset($error) && !empty($error)) {
			echo "<div class=\"alert alert-danger\">{$error}</div>";
			$_SESSION['error'] = NULL;
		}
	}

	public static function flash_error_message($error) {
		session_start();
		$_SESSION['error'] = $error;
	}

	public static function current_user() {
		session_start();
		$email = $_SESSION['current_user_email'];
		return User::find($email);
	}

	public static function set_current_user($user) {
		if (isset($user) && isset($user->email)) {
			session_start();
			$_SESSION['current_user_email'] = $user->email;
			return User::find($email);	
		}
		return NULL;
	}

	public static function destroy_session() {
		session_start();
		$_SESSION = array();
		session_destroy();
	}
}