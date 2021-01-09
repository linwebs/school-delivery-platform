<?php

use database\area;
use database\build;
use database\meal;
use database\order;
use database\place;
use database\room;
use database\shop;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/shop.php';
require_once FOLDER_PATH . 'database/meal.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/room.php';
require_once FOLDER_PATH . 'database/place.php';
require_once FOLDER_PATH . 'database/order.php';

class car_checkout {
	public function __construct() {
		if (empty($_SESSION['place']['selected'])) {
			header('Location: /place');
			die();
		}
		/*
				echo 'checkout' . '<br>';
				echo 'place name: ' . $_POST['place_name'] . '<br>';
				echo 'place detail: ' . $_POST['place_detail'] . '<br>';
				echo 'order detail: ' . $_POST['order_detail'] . '<br>';
				echo '<pre>';
				print_r($_SESSION);
				echo '</pre>';
		*/
		if (!isset($_POST['place_name'])) {
			$this->error('未輸入地點名稱');
		}

		// check shop status ?
		if (!isset($_SESSION['car']['shop'])) {
			$this->error('無法取得店家');
		}

		$shop = shop::get_single($_SESSION['car']['shop']);

		if (!isset($shop['id'])) {
			$this->error('無此店家，店家編號: ' . $_SESSION['car']['shop']);
		}

		if ($shop['status'] != '1') {
			$this->error('此店家目前未營業，暫未開放點餐');
		}

		// check meal status ?
		if (!isset($_SESSION['car']['meal'])) {
			$this->error('無法取得餐點');
		}

		if (count($_SESSION['car']['meal']) == 0) {
			$this->error('無任何餐點');
		}

		foreach ($_SESSION['car']['meal'] as $item) {
			$meal = meal::get_single($item['id']);

			if (!isset($meal['id'])) {
				$this->error('無此餐點，餐點編號: ' . $item['id']);
			}

			if ($meal['status'] != '1') {
				$this->error('目前未提供此餐點: ' . $meal['name'] . '，請從購物車中移除！');
			}
		}

		/*
		 *
		$_SESSION['place']['selected'] = true;
		$_SESSION['place']['area'] = router\router::locale()[2];
		$_SESSION['place']['build'] = $_POST['build'];
		$_SESSION['place']['room'] = $_POST['room'];
		 */


		// check place in my ?
		if (!isset($_SESSION['place']['my'])) {
			$this->error('地點資訊錯誤');
		}

		$my_place_id = 0;
		if ($_SESSION['place']['my'] == false) {
			$place_id = 0;
			if (!isset($_SESSION['place']['area'])) {
				$this->error('無法取得地點資訊，請重新選擇送餐地點<br>Error ID: [car-error-1]');
			}
			if (!isset($_SESSION['place']['build'])) {
				$this->error('無法取得地點資訊，請重新選擇送餐地點<br>Error ID: [car-error-2]');
			}
			if (!isset($_SESSION['place']['room'])) {
				$this->error('無法取得地點資訊，請重新選擇送餐地點<br>Error ID: [car-error-3]');
			}

			$exist_room = room::get_room_from_name_build_id_area_id($_SESSION['place']['room'], $_SESSION['place']['build'], $_SESSION['place']['area']);
			if (!isset($exist_room['place_room_id'])) {
				$place_id = $exist_room['place_room_id'];
			} else {
				// add room
				$area = area::get_single($_SESSION['place']['area']);
				if (!isset($area['name'])) {
					// can't get area
					$this->error('無法取得地點資訊，請重新選擇送餐地點<br>Error ID: [car-error-4]');
				}

				if ($shop['area_id'] != $area['id']) {
					$this->error('無法將此餐廳的餐點外送至此地點，請重新選擇送餐地點');
				}

				$build = build::get_single_from_id_area_id($_SESSION['place']['build'], $_SESSION['place']['area']);

				if (!isset($build['build_id'])) {
					// can't get build from area
					$this->error('無法取得地點資訊，請重新選擇送餐地點<br>Error ID: [car-error-5]');
				}

				// 	false -> create [place_room]
				$room = room::add_room($_SESSION['place']['build'], $_SESSION['place']['room']);

				if ($room) {
					$place_id = $room;
				} else {
					$this->error('無法指定此地點，請重新選擇送餐地點');
				}
			}

			if ($place_id == 0) {
				$this->error('無法取得地點資訊，請重新選擇送餐地點<br>Error ID: [car-error-6]');
			}

			// 	false -> create [user_place]
			$my_place_id = place::add_user_place($_SESSION['user']['id'], $place_id, $_POST['place_name'], $_POST['place_detail']);
		} else {
			$user_place = place::get_my_place_id($_SESSION['place']['my']);

			if (!isset($user_place['place_id'])) {
				$this->error('無法取得地點資訊，請重新選擇送餐地點<br>Error ID: [car-error-7]');
			}

			$place = place::get_user_single($_SESSION['user']['id'], $user_place);

			if (!isset($place['user_place_id'])) {
				$this->error('無法取得地點資訊，請重新選擇送餐地點<br>Error ID: [car-error-8]');
			}

			$my_place_id = $place['user_place_id'];

			if (!place::update_user_place($my_place_id, $_POST['place_name'], $_POST['place_detail'])) {
				$this->error('無法更新地點資訊，請稍後再重新送出訂單');
			}
			// 	true -> update [user_place]
		}

		$order_detail = '';
		if (isset($_POST['order_detail'])) {
			$order_detail = $_POST['order_detail'];
		}

		// add order to [user_order] => get_id
		$order = order::add_order($_SESSION['user']['id'], $shop['id'], $my_place_id, $order_detail);

		if (!$order) {
			$this->error('無法送出訂單，請稍後再試');
		}

		// use id => add all meal to [order_meal]
		foreach ($_SESSION['car']['meal'] as $item) {
			$order_meal = order::add_order_meal($order, $item['id'], $item['quantity'], $item['note']);

			if (!$order_meal) {
				$this->error('無法送出訂單餐點，餐點編號: ' . $item['id'] . '，請稍後再試');
			}
		}

		$this->success($order);
	}

	private function success($order) {
		unset($_SESSION['car']);
		header('Location: /ticket/' . $order);
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
}