<?php

use database\tickets;
use view\view;

require_once FOLDER_PATH . 'database/tickets.php';

class tickets_new {
	public function __construct() {
		if(!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		if($_SESSION['user']['type'] != '2') {
			header('Location: /ticket');
			die();
		}

		$tickets = tickets::get_all_tickets_need_delivery();

		view::func('tickets/new', function () use ($tickets) {
			return [
				'tickets' => $tickets
			];
		});
	}
}