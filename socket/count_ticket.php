<?php

namespace socket;

use database\order;
use database\user;
use view\view;

require_once FOLDER_PATH . 'database/order.php';

class count_ticket {
	/**
	 * Error message
	 * @var string
	 */
	private string $msg;

	public function count_ticket($token): array {
		$user = user::token_verify($token);

		if (!$user) {
			$this->msg = '無此使用者';
			return $this->json_error();
		}

		$order_list = order::get_user_order($user['id']);

		//echo '使用者:' . $user['name'] . "\n";

		return array(
			'action' => 'ticket_status',
			'status' => 'ok',
			'msg' => '訂單筆數查詢成功',
			'count' => count($order_list)
		);
	}

	/**
	 * Login Failed return
	 * @return array
	 */
	private function json_error(): array {
		return array(
			'action' => 'ticket_status',
			'status' => 'error',
			'msg' => ($this->msg ?: '訂單筆數查詢失敗'),
			'count' => null
		);
	}
}