<?php

use database\tickets;
use view\view;

require_once FOLDER_PATH . 'database/tickets.php';

class order {
	public function __construct() {
		if(!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		if($_SESSION['user']['type'] != '3') {
			header('Location: /ticket');
			die();
		}

		$my_tickets = tickets::get_shop_all_tickets($_SESSION['user']['id']);

		view::func('order/all', function () use ($my_tickets) {
			return [
				'ticket' => $my_tickets
			];
		});
	}
}