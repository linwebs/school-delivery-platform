<?php


use view\view;

class register_page {
	public function __construct() {
		if(isset($_SESSION['user']['id'])) {
			header('Location: /account');
			die();
		}

		view::view('register');
	}
}