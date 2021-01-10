<?php

use database\tickets;
use view\view;

require_once FOLDER_PATH . 'database/tickets.php';

class order_change {
	public function __construct($param) {
		if (!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		if ($_SESSION['user']['type'] != '3') {
			header('Location: /ticket');
			die();
		}

		if (!isset($_POST['status'])) {
			$_SESSION['order_error'] = '無法取得訂單狀態';
			header('Location: /order/' . $param);
			die();
		}

		$tickets = tickets::get_shop_single_tickets($param, $_SESSION['user']['id']);

		if (!isset($tickets['order_id'])) {
			$_SESSION['order_error'] = '無法取得此訂單資訊';
			header('Location: /order/' . $param);
			die();
		}

		print_r($tickets);

		if($tickets['order_status'] != 1 && $tickets['order_status'] != 2) {
			$_SESSION['order_error'] = '無法變更此訂單資訊';
			header('Location: /order/' . $param);
			die();
		}

		switch ($_POST['status']) {
			case 'start_prepare':
				if (!tickets::change_shop_tickets_status($param, $_SESSION['user']['id'], 2)) {
					$_SESSION['order_error'] = '訂單狀態變更失敗';
					header('Location: /order/' . $param);
					die();
				} else {
					$_SESSION['order_error'] = '訂單狀態已變更為【餐點準備中】';
				}
				break;
			case 'prepare_finish':
				if (!tickets::change_shop_tickets_status($param, $_SESSION['user']['id'], 3)) {
					$_SESSION['order_error'] = '訂單狀態變更失敗';
					header('Location: /order/' . $param);
					die();
				} else {
					$_SESSION['order_error'] = '訂單狀態已變更為【等待送餐中】';
				}
				break;
			default:
				$_SESSION['order_error'] = '無法變更此訂單資訊';
				header('Location: /order/' . $param);
				die();
		}

		header('Location: /order/' . $param);
	}
}