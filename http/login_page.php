<?php


use view\view;

class login_page {
	public function __construct() {
		if(isset($_SESSION['user']['id'])) {
			header('Location: /account');
			die();
		}

		view::view('login');
	}
}