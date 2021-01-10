<?php

use database\tickets;
use view\view;

require_once FOLDER_PATH . 'database/tickets.php';

class tickets_my {
	public function __construct() {
		if(!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		if($_SESSION['user']['type'] != '2') {
			header('Location: /ticket');
			die();
		}

		$my_tickets = tickets::get_delivery_all_tickets($_SESSION['user']['id']);

		view::func('tickets/my', function () use ($my_tickets) {
			return [
				'tickets' => $my_tickets
			];
		});
	}
}