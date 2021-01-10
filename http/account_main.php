<?php

use database\user;
use view\view;

require_once FOLDER_PATH . 'database/user.php';

class account_main {
	public function __construct() {
		if(!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		switch ($_SESSION['user']['type']) {
			case 1:
				view::func('account/main', function () {
					return [
						'user' => user::get_single($_SESSION['user']['id'])
					];
				});
				break;
			case 2:
				view::func('account/main_delivery', function () {
					return [
						'user' => user::get_single($_SESSION['user']['id'])
					];
				});
				break;
			case 3:
				view::func('account/main_shop', function () {
					return [
						'user' => user::get_single($_SESSION['user']['id'])
					];
				});
				break;
		}

	}
}