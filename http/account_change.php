<?php

class account_change {
	public function __construct() {
		if(!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		if($_SESSION['user']['type'] == 2 || $_SESSION['user']['type'] == 3) {
			$_SESSION['user']['type'] = 1;

			header('Location: /account');
			die();
		}
	}
}