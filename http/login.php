<?php

use database\user;

require_once FOLDER_PATH . 'database/user.php';

class login {
	private $account;
	private $password;

	public function __construct() {
		// login from post
		if($this->login_from_post()) {
			header('Location: /ticket');
		} else {
			header('Location: /login');
		}
	}

	private function login_from_post(): bool {
		if ($this->has_account_password()) {
			unset($_SESSION['login_error']);
			$verify = $this->verify_from_db();
			if ($verify) {
				$_SESSION['id'] = $verify['id'];
				$_SESSION['account'] = $verify['account'];
				$_SESSION['name'] = $verify['name'];
				$_SESSION['type'] = $verify['type'];
				return true;
			} else {
				// verify db failed
				$_SESSION['login_error'] = true;
				return false;
			}
		} else {
			// no input
			return  false;
		}
	}

	private function has_account_password(): bool {
		if (!isset($_POST['account'])) {
			// no account
			return false;
		} elseif (!isset($_POST['password'])) {
			// no password
			return false;
		} else {
			if (empty($_POST['account'])) {
				// empty account
				return false;
			} elseif (empty($_POST['password'])) {
				// empty password
				return false;
			} else {
				$this->account = $_POST['account'];
				$this->password = $_POST['password'];
				return true;
			}
		}
	}

	private function verify_from_db() {
		return user::verify($this->account, $this->password);
	}
}

new login();