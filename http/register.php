<?php

use database\user;
use lang\lang;
use view\view;

require_once FOLDER_PATH . 'database/user.php';

class register {
	/* 6~20 word and a-z A-Z 0-9 _ - */
	private $account;
	/* 1~64 word */
	private $name;
	/* email format */
	private $email;
	/* phone format */
	private $phone;
	/* at least 6 word */
	private $password;
	/* 1 => customer, 2 => delivery, 3 => shop */
	private $type;

	public function __construct() {
		// verify all field input ?
		if (!$this->verify_input()) {
			view::view('register');
			return;
		}
		// verify account email use ?
		if (!$this->verify_exist()) {
			view::view('register');
			return;
		}

		// default user
		$this->type = 1;

		// add to sql
		$user_id = $this->add_to_sql();
		if(!$user_id) {
			view::view('register');
			return;
		}
		$this->success_register($user_id);
	}

	private function success_register($user_id) {
		$_SESSION['id'] = $user_id;
		$_SESSION['account'] = $this->account;
		$_SESSION['name'] = $this->name;
		$_SESSION['type'] = $this->type;
		header('Location: /ticket');
	}

	private function add_to_sql(): string {
		return user::add_user($this->account, $this->name, $this->email, $this->phone, $this->password, $this->type);
	}

	private function verify_exist(): bool {
		// account exist ?
		if (user::account_exist($this->account)) {
			$_SESSION['register_error'] = lang::lang('account_already_use');
			$_SESSION['register_account'] = lang::lang('six_to_twenty_word_only');
			return false;
		}
		// email exist ?
		if (user::email_exist($this->email)) {
			$_SESSION['register_error'] = lang::lang('email_already_use');
			$_SESSION['register_account'] = '';
			return false;
		}
		return true;
	}

	private function verify_input() {
		// default true
		$verified = true;

		// is isset ?
		if (!isset($_POST['account'])) {
			// no account
			$_SESSION['register_account'] = lang::lang('no_account');
			$verified = false;
		}
		if (!isset($_POST['name'])) {
			// no name
			$_SESSION['register_name'] = lang::lang('no_name');
			$verified = false;
		}
		if (!isset($_POST['email'])) {
			// no email
			$_SESSION['register_email'] = lang::lang('no_email');
			$verified = false;
		}
		if (!isset($_POST['phone'])) {
			// no phone
			$_SESSION['register_phone'] = lang::lang('no_phone');
			$verified = false;
		}
		if (!isset($_POST['password'])) {
			// no password
			$_SESSION['register_password'] = lang::lang('no_password');
			$verified = false;
		}
		if (!isset($_POST['password_again'])) {
			// no password again
			$_SESSION['register_password_again'] = lang::lang('no_password_again');
			$verified = false;
		}
		if (!$verified) {
			return false;
		}

		// is empty ?
		if (empty($_POST['account'])) {
			// empty account
			$_SESSION['register_account'] = lang::lang('empty_account');
			echo '123';
			$verified = false;
		}
		if (empty($_POST['name'])) {
			// empty name
			$_SESSION['register_name'] = lang::lang('empty_name');
			$verified = false;
		}
		if (empty($_POST['email'])) {
			// empty email
			$_SESSION['register_email'] = lang::lang('empty_email');
			$verified = false;
		}
		if (empty($_POST['phone'])) {
			// empty phone
			$_SESSION['register_phone'] = lang::lang('empty_phone');
			$verified = false;
		}
		if (empty($_POST['password'])) {
			// empty password
			$_SESSION['register_password'] = lang::lang('empty_password');
			$verified = false;
		}
		if (empty($_POST['password_again'])) {
			// empty password again
			$_SESSION['register_password_again'] = lang::lang('empty_password_again');
			$verified = false;
		}
		if (!$verified) {
			return false;
		}

		// verify account include a-z A-Z 0-9 _ - and 6~20 word
		if (!preg_match("/^[a-zA-Z0-9_-]{6,20}+$/", $_POST['account'])) {
			$_SESSION['register_account'] = lang::lang('six_to_twenty_word_only');
			$verified = false;
		}

		// verify name length
		if (strlen($_POST['name']) > 64) {
			$_SESSION['register_name'] = lang::lang('no_correct_name');
			$verified = false;
		}

		// verify email
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['register_email'] = lang::lang('no_correct_email');
			$verified = false;
		}

		// verify phone
		if (strlen($_POST['phone']) < 9) {
			$_SESSION['register_phone'] = lang::lang('no_correct_phone');
			$verified = false;
		} elseif (strlen($_POST['phone']) > 64) {
			$_SESSION['register_phone'] = lang::lang('no_correct_phone');
			$verified = false;
		}

		// verify password
		if (strlen($_POST['password']) < 6) {
			$_SESSION['register_password'] = lang::lang('no_correct_password');
			$verified = false;
		}

		// verify password again
		if ($_POST['password'] != $_POST['password_again']) {
			$_SESSION['register_password_again'] = lang::lang('diff_password');
			$verified = false;
		}

		if (!$verified) {
			$_SESSION['register_account_last'] = $_POST['account'];
			$_SESSION['register_name_last'] = $_POST['name'];
			$_SESSION['register_email_last'] = $_POST['email'];
			$_SESSION['register_phone_last'] = $_POST['phone'];
			$_SESSION['register_error'] = lang::lang('check_register_column');
			return false;
		} else {
			$this->account = $_POST['account'];
			$this->name = $_POST['name'];
			$this->email = $_POST['email'];
			$this->phone = $_POST['phone'];
			$this->password = $_POST['password'];
			return true;
		}
	}
}