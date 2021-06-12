<?php

namespace socket;

use database\order;
use database\place;
use database\user;

require_once FOLDER_PATH . 'database/order.php';

class ticket_status {
	/**
	 * Error message
	 * @var string
	 */
	private string $msg;

	/**
	 * @param $token
	 * @param $order
	 * @return array
	 */
	public function ticket_status($token, $order): array {
		$user = user::token_verify($token);

		if (!$user) {
			$this->msg = '無此使用者';
			return $this->json_error();
		}

		$order_list = order::get_user_single_order_from_turn($user['id'], $order-1);

		if (!isset($order_list['order_id'])) {
			$this->msg = '此訂單不存在';
			return $this->json_error();
		}

		if ($order_list['user_id'] != $user['id']) {
			$this->msg = '此訂單不屬於此使用者';
			return $this->json_error();
		}

		$meals = order::get_ticket_order_meal($order_list['order_id']);

		/*
		meals = array (
			[0] => Array
				(
					[meal_id] => 1
					[name] => 黃金大豬便當
					[price] => 65
					[quantity] => 1
					[note] =>
				)

		)
		 */

		if(count($meals) == 0) {
			$this->msg = '此訂單無餐點';
			return $this->json_error();
		}

		if (!isset($meals[0]['meal_id'])) {
			// Error: meal no found
			$this->msg = '餐點名稱錯誤';
			return $this->json_error();
		}
		/*else {
			$price_meals += $meals[0]['quantity'] * $meals[0]['price'];
		}*/

		/*
		$order_list = array (
			[order_id] => 1
			[user_id] => 18
			[order_status] => 1
			[order_time] => 2021-06-10 01:40:42
			[order_note] =>
			[shop_id] => 1
			[shop_name] => 學員簡速餐
			[delivery_name] =>
			[delivery_phone] =>
			[user_place_id] => 1
			[user_place_name] => 我的新地點
			[user_place_detail] =>
			[room_name] => 教務處
			[build_name] => 行政中心
			[area_name] => 蘭潭校區
		);
		 */

		$place = place::get_user_single($user['id'], $order_list['user_place_id']);

		/*
		$place = array (
			[user_place_id] => 1
			[user_place_name] => 我的新地點
			[user_place_detail] =>
			[room_id] => 25
			[room_name] => 教務處
			[build_id] => 1
			[build_name] => 行政中心
			[area_id] => 1
			[area_name] => 蘭潭校區
		)
		 */

		return array(
			'action' => 'ticket_status',
			'status' => 'ok',
			'msg' => '訂單狀態查詢成功',
			'id' => $order_list['order_id'],
			'area' => $place['area_id'],
			'build' => $place['build_id'],
			'room' => $place['room_id'],
			'shop' => $order_list['shop_id'],
			'meal' => $meals[0]['meal_id'],
			'quantity' => $meals[0]['quantity'],
			'order_status' => $order_list['order_status']
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
			'msg' => ($this->msg ?: '訂單狀態查詢失敗'),
			'id' => null,
			'area' => null,
			'build' => null,
			'room' => null,
			'shop' => null,
			'meal' => null,
			'quantity' => null,
			'order_status' => null
		);
	}
}