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
		if (isset($_SESSION['user']['id'])) {
			if (is_numeric($_SESSION['user']['id'])) {
				$this->login = true;
			}
		}
	}

	private function show_navbar() {
		if ($this->login) {
			switch ($_SESSION['user']['type']) {
				case 1:
					view::view('navbar/user');
					break;
				case 2:
					view::view('navbar/delivery');
					break;
				case 3:
					view::view('navbar/shop');
					break;
			}
		} else {
			view::view('navbar/no_login');
		}
	}

}

new navbar();