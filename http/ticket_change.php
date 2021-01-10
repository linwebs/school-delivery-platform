<?php

use database\order;
use database\tickets;

require_once FOLDER_PATH . 'database/order.php';
require_once FOLDER_PATH . 'database/tickets.php';

class ticket_change {
	public function __construct($param) {
		if (!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		if ($_SESSION['user']['type'] != '1') {
			header('Location: /ticket');
			die();
		}

		if (!isset($_POST['status'])) {
			$_SESSION['ticket_error'] = '無法取得訂單狀態';
			header('Location: /ticket/' . $param);
			die();
		}

		$tickets = order::get_user_single_order($_SESSION['user']['id'], $param);

		if (!isset($tickets['order_id'])) {
			$_SESSION['ticket_error'] = '無法取得此訂單資訊';
			header('Location: /ticket/' . $param);
			die();
		}

		if($tickets['order_status'] != 5) {
			$_SESSION['ticket_error'] = '無法變更此訂單資訊';
			header('Location: /ticket/' . $param);
			die();
		}

		switch ($_POST['status']) {
			case 'ticket_finish':
				if (!tickets::change_user_tickets_status($param, $_SESSION['user']['id'], 6)) {
					$_SESSION['ticket_error'] = '訂單狀態變更失敗';
					header('Location: /ticket/' . $param);
					die();
				} else {
					$_SESSION['ticket_error'] = '訂單狀態已變更為【訂單已完成】';
				}
				break;
			default:
				$_SESSION['ticket_error'] = '無法變更此訂單資訊';
				header('Location: /ticket/' . $param);
				die();
		}

		header('Location: /ticket/' . $param);
	}
}