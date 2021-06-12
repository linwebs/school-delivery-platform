<?php

namespace socket;

use database\user;

require_once FOLDER_PATH . 'database/user.php';

class login {
	/**
	 * User ID
	 * @var int
	 */
	private int $id;

	/**
	 * User name
	 * @var string
	 */
	private string $name;

	/**
	 * User account name
	 * 6~20 word and a-z A-Z 0-9 _ -
	 * @var string
	 */
	private string $account;

	/**
	 * User password
	 * at least 6 word
	 * @var string
	 */
	private string $password;

	/**
	 * User type
	 *    1 => customer
	 *    2 => delivery
	 *    3 => shop
	 * @var int
	 */
	private int $type;

	/**
	 * User login token
	 * @var string
	 */
	private string $token;

	/**
	 * Error message
	 * @var string
	 */
	private string $msg;

	/**
	 * login constructor.
	 */
	public function __construct() {

	}

	/**
	 * @param $account
	 * @param $password
	 * @return array
	 */
	public function login($account, $password): array {
		// login from socket
		if ($this->login_from_socket($account, $password)) {
			switch ($this->type) {
				case 1:
					// customer
					return $this->get_token();
				case 2:
					// delivery
					return $this->get_token();
				case 3:
					// shop
					return $this->get_token();
				default:
					// error
					return $this->json_error();
			}
		} else {
			//header('Location: /login');
			return $this->json_error();
		}
	}

	public function logout($token):array {
		if(user::logout_token($token)) {
			return array(
				'action' => 'logout',
				'status' => 'ok',
				'msg' => '登出成功'
			);
		} else {
			return array(
				'action' => 'logout',
				'status' => 'error',
				'msg' => '登出失敗'
			);
		}
	}

	/**
	 * Login success return
	 * @return array
	 */
	private function json_success(): array {
		return array(
			'action' => 'login',
			'status' => 'ok',
			'msg' => '登入成功',
			'token' => $this->token,
			'type' => $this->type
		);
	}

	/**
	 * Login Failed return
	 * @return array
	 */
	private function json_error(): array {
		return array(
			'action' => 'login',
			'status' => 'error',
			'msg' => ($this->msg ?: '登入失敗'),
			'token' => null,
			'type' => null
		);
	}

	/**
	 * Generate user token
	 * @return array
	 */
	private function get_token(): array {
		$token = md5(uniqid(rand(), true));
		if (user::token_add($this->id, $token)) {
			$this->token = $token;
			return $this->json_success();
		} else {
			$this->msg = '使用者token建立失敗';
			return $this->json_error();
		}
	}

	/**
	 * Login from socket information
	 * @param string $account 使用者帳號
	 * @param string $password 使用者密碼
	 * @return bool
	 */
	private function login_from_socket(string $account, string $password): bool {
		if ($this->has_account_password($account, $password)) {
			$verify = $this->verify_from_db();
			if ($verify) {
				$this->id = $verify['id'];
				$this->name = $verify['name'];
				$this->type = $verify['type'];
				return true;
			} else {
				// verify db failed
				$this->msg = '帳號或密碼錯誤';
				return false;
			}
		} else {
			// no input
			return false;
		}
	}

	/**
	 * Check account and password not empty
	 * @param string $account 使用者帳號
	 * @param string $password 使用者密碼
	 * @return bool
	 */
	private function has_account_password(string $account, string $password): bool {
		if (!isset($account)) {
			// no account
			$this->msg = '帳號不得為空';
			return false;
		} elseif (!isset($password)) {
			// no password
			$this->msg = '密碼不得為空';
			return false;
		} else {
			if (empty($account)) {
				// empty account
				$this->msg = '帳號不得為空';
				return false;
			} elseif (empty($password)) {
				// empty password
				$this->msg = '密碼不得為空';
				return false;
			} else {
				$this->account = $account;
				$this->password = $password;
				return true;
			}
		}
	}

	/**
	 * Verify user account in database
	 * @return mixed
	 */
	private function verify_from_db() {
		return user::verify($this->account, $this->password);
	}
}