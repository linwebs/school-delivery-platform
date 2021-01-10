<?php

use database\user;
use lang\lang;

require_once FOLDER_PATH . 'database/user.php';

class login {
	/* 6~20 word and a-z A-Z 0-9 _ - */
	private $account;
	/* at least 6 word */
	private $password;
	/* 1 => customer, 2 => delivery, 3 => shop */
	private $type;

	public function __construct() {
		if(isset($_SESSION['user']['id'])) {
			header('Location: /account');
			die();
		}

		// login from post
		if($this->login_from_post()) {
			switch ($this->type) {
				case 1:
					// customer
					header('Location: /ticket');
					break;
				case 2:
					// delivery
					header('Location: /tickets/my');
					break;
				case 3:
					// shop
					header('Location: /order');
					break;
				default:
					// error
					header('Location: /404');
			}
		} else {
			header('Location: /login');
		}
	}

	private function login_from_post(): bool {
		if ($this->has_account_password()) {
			unset($_SESSION['login_error']);
			$verify = $this->verify_from_db();
			if ($verify) {
				$this->type = $verify['type'];
				$_SESSION['user']['id'] = $verify['id'];
				$_SESSION['user']['account'] = $verify['account'];
				$_SESSION['user']['name'] = $verify['name'];
				$_SESSION['user']['type'] = $verify['type'];
				return true;
			} else {
				// verify db failed
				$_SESSION['login_error'] = lang::lang('account_password_error');
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