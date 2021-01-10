<?php

use database\order;
use view\view;

require_once FOLDER_PATH . 'database/order.php';

class ticket {
	public function __construct() {
		if(!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		$order_list = order::get_user_order($_SESSION['user']['id']);

		view::func('ticket/list', function () use ($order_list) {
			return [
				'order' => $order_list
			];
		});
	}
}