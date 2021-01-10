<?php

use database\order;
use view\view;

require_once FOLDER_PATH . 'database/order.php';

class ticket_detail {
	public function __construct($param) {
		if (!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		$order_list = order::get_user_single_order($_SESSION['user']['id'], $param);

		if (!isset($order_list['order_id'])) {
			header('Location: /ticket/no_found');
			die();
		}

		if($order_list['user_id'] != $_SESSION['user']['id']) {
			header('Location: /ticket');
			die();
		}

		$meals = order::get_ticket_order_meal($order_list['order_id']);

		$price_meals = 0;

		foreach ($meals as $item) {
			if (!isset($item['meal_id'])) {
				// Error: meal no found
				echo 'error';
			} else {
				$price_meals += $item['quantity'] * $item['price'];
			}
		}
		$price_total = $price_meals + DELIVERY_FEE;

		view::func('ticket/detail', function () use ($order_list, $meals, $price_meals, $price_total) {
			return [
				'order' => $order_list,
				'meal' => $meals,
				'price_meals' => $price_meals,
				'price_delivery' => DELIVERY_FEE,
				'price_total' => $price_total
			];
		});
	}
}