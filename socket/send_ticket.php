<?php

namespace socket;

use database\area;
use database\build;
use database\meal;
use database\order;
use database\place;
use database\room;
use database\shop;
use database\user;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/shop.php';
require_once FOLDER_PATH . 'database/meal.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/room.php';
require_once FOLDER_PATH . 'database/place.php';
require_once FOLDER_PATH . 'database/order.php';

class send_ticket {

	/**
	 * Error message
	 * @var string
	 */
	private string $msg;

	/**
	 * User place name
	 * Combine build + room
	 * @var string
	 */
	private string $place_name;

	/**
	 * @param string $token
	 * @param int    $area_id
	 * @param int    $build_id
	 * @param int    $room_id
	 * @param int    $shop_id
	 * @param int    $meal_id
	 * @param int    $quantity
	 * @return array
	 */
	public function send_ticket(string $token, int $area_id, int $build_id, int $room_id, int $shop_id, int $meal_id, int $quantity): array {
		$user = user::token_verify($token);

		if (!$user) {
			$this->msg = '無此使用者';
			return $this->json_error();
		}

		$build = build::get_single_from_id_area_id($build_id, $area_id);

		if (!$build) {
			$this->msg = '建築物不位於此地區';
			return $this->json_error();
		}

		if ($quantity == 0) {
			// no quantity
			$this->msg = '餐點數量不得為0';
			return $this->json_error();
		}

		$shop = shop::get_single($shop_id);

		if (!isset($shop['id'])) {
			$this->msg = '無此店家';
			return $this->json_error();
		}

		if ($shop['status'] != '1') {
			$this->msg = '此店家目前未營業，暫未開放點餐';
			return $this->json_error();
		}

		if ($build_id != $shop['area_id']) {
			// shop not in this area
			$this->msg = '餐點的商店不在外送範圍內';
			return $this->json_error();
		}

		$meal = meal::get_single($meal_id);

		if (!isset($meal['id'])) {
			$this->msg = '無此餐點';
			return $this->json_error();
		}

		if ($meal['status'] != '1') {
			$this->msg = '目前未提供此餐點';
			return $this->json_error();
		}

		if ($quantity > ITEM_MAX_BUY) {
			$this->msg = '餐點數量超過購買上限';
			return $this->json_error();
		}

		$this->place_name = build::get_name($build_id) . '_' . room::get_name($room_id);

		if (mb_strlen($this->place_name) > 30) {
			$this->place_name = mb_substr($this->place_name, 0, 30);
		}

		/// ...
		$room_name = room::get_name($room_id);

		$exist_room = room::get_room_from_name_build_id_area_id($room_name, $build_id, $area_id);

		if (!isset($exist_room['place_room_id'])) {
			$this->msg = '無此送餐地點';
			return $this->json_error();
		}

		$user_place = place::get_my_place_from_name($user['id'], $this->place_name);

		$place_id = 0;
		if (isset($user_place['place_id'])) {
			$place_id = $user_place['place_id'];
		} else {
			// no user place
			$place_id = place::add_user_place($user['id'], $exist_room['place_room_id'], $this->place_name, '');
		}

		$area = area::get_single($area_id);

		if (!isset($area['id'])) {
			// can't get area
			$this->msg = '無法取得地點資訊';
			return $this->json_error();
		}

		if ($shop['area_id'] != $area['id']) {
			$this->msg = '無法將此餐廳的餐點外送至此地點';
			return $this->json_error();
		}

		// add order to [user_order] => get_id
		$order = order::add_order($user['id'], $shop['id'], $place_id, '');

		if (!$order) {
			$this->msg = '無法送出訂單，請稍後再試';
			return $this->json_error();
		}

		// use id => add all meal to [order_meal]
		$order_meal = order::add_order_meal($order, $meal_id, $quantity, '');

		if (!$order_meal) {
			$this->error('無法送出訂單餐點，餐點編號: ' . $meal_id . '，請稍後再試');
		}


		return array('action' => 'send_ticket', 'status' => 'error', 'msg' => '成功送出訂單', 'id' => $order);
	}

	private function error($msg) {
		$_SESSION['car_error'] = $msg;
		if (isset($_POST['place_name'])) {
			$_SESSION['car_last']['place_name'] = $_POST['place_name'];
		}
		if (isset($_POST['place_detail'])) {
			$_SESSION['car_last']['place_detail'] = $_POST['place_detail'];
		}
		if (isset($_POST['order_detail'])) {
			$_SESSION['car_last']['ticket_note'] = $_POST['order_detail'];
		}
		header('Location: /car/error');
		die();
	}

	/**
	 * Login Failed return
	 * @return array
	 */
	private function json_error(): array {
		return array('action' => 'send_ticket', 'status' => 'error', 'msg' => ($this->msg ?: '訂單送出失敗'), 'id' => null);
	}
}