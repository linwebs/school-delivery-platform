<?php

use database\tickets;
use view\view;

require_once FOLDER_PATH . 'database/tickets.php';

class tickets_change {
	public function __construct($param) {
		if(!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		if($_SESSION['user']['type'] != '2') {
			header('Location: /ticket');
			die();
		}

		if(!isset($_POST['status'])) {
			$_SESSION['tickets_error'] = '無法取得訂單狀態';
			header('Location: /tickets/' . $param);
			die();
		}

		if($_POST['status'] == 'get_ticket') {
			$tickets = tickets::get_single_tickets_need_delivery($param);

			if(!isset($tickets['order_id'])) {
				$_SESSION['tickets_error'] = '無法接下此訂單，此訂單可能以被其他外送員接單';
				header('Location: /tickets/' . $param);
				die();
			}
		} else {
			$ticket = tickets::get_delivery_single_tickets($param, $_SESSION['user']['id']);

			if(!isset($ticket['order_id'])) {
				$_SESSION['tickets_error'] = '您無此訂單';
				header('Location: /tickets/' . $param);
				die();
			}
		}

		switch ($_POST['status']) {
			case 'get_ticket':
				if(!tickets::change_tickets_delivery($param, $_SESSION['user']['id'])) {
					$_SESSION['tickets_error'] = '訂單狀態變更失敗';
					header('Location: /tickets/' . $param);
					die();
				} else {
					$_SESSION['tickets_error'] = '已接下此訂單';
				}
				break;
			case 'get_meal':
				if(!tickets::change_delivery_tickets_status($param, $_SESSION['user']['id'], 4)) {
					$_SESSION['tickets_error'] = '訂單狀態變更失敗';
					header('Location: /tickets/' . $param);
					die();
				} else {
					$_SESSION['tickets_error'] = '訂單狀態已變更為【餐點外送中】';
				}
				break;
			case 'delivery_finish':
				if(!tickets::change_delivery_tickets_status($param, $_SESSION['user']['id'], 5)) {
					$_SESSION['tickets_error'] = '訂單狀態變更失敗';
					header('Location: /tickets/' . $param);
					die();
				} else {
					$_SESSION['tickets_error'] = '訂單狀態已變更為【餐點已送達】';
				}
				break;
			default:
				$_SESSION['tickets_error'] = '無法變更此訂單資訊';
				header('Location: /tickets/' . $param);
				die();
		}

		header('Location: /tickets/' . $param);
	}
}