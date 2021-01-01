<?php

use view\view;

class navbar {
	private bool $login;

	public function __construct() {
		$this->login = false;
		$this->check_login();
		$this->show_navbar();
	}

	private function check_login() {
		if (isset($_SESSION['id'])) {
			if (is_numeric($_SESSION['id'])) {
				$this->login = true;
			}
		}
	}

	private function show_navbar() {
		if ($this->login) {
			view::view('navbar/login');
		} else {
			view::view('navbar/no_login');
		}
	}

}

new navbar();