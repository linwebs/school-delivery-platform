<?php

use database\order;
use database\tickets;
use view\view;

require_once FOLDER_PATH . 'database/order.php';
require_once FOLDER_PATH . 'database/tickets.php';

class tickets_detail {
	public function __construct($param) {
		if(!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		if($_SESSION['user']['type'] != '2') {
			header('Location: /ticket');
			die();
		}

		$tickets = tickets::get_delivery_single_tickets($param, $_SESSION['user']['id']);

		if (!isset($tickets['order_id'])) {
			$tickets = tickets::get_single_tickets_need_delivery($param);

			if(!isset($tickets['order_id'])) {
				header('Location: /ticket/no_found');
				die();
			}
		}

		$meals = order::get_ticket_order_meal($tickets['order_id']);

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

		view::func('tickets/detail', function () use ($tickets, $meals, $price_meals, $price_total) {
			return [
				'tickets' => $tickets,
				'meal' => $meals,
				'price_meals' => $price_meals,
				'price_delivery' => DELIVERY_FEE,
				'price_total' => $price_total
			];
		});
	}
}