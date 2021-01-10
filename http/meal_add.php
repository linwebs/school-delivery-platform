<?php

use database\meal;
use database\shop;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/shop.php';
require_once FOLDER_PATH . 'database/meal.php';

class meal_add {
	public function __construct($param) {

		if (!isset($_SESSION['user']['id'])) {
			// no login
			header('Location: /login');
			die();
		}

		if (empty($_SESSION['place']['selected'])) {
			header('Location: /place');
			die();
		}

		if (!isset($_POST['shop'])) {
			// no shop
			header('Location: /shop');
			die();
		}

		if (!isset($_POST['meal'])) {
			// no meal
			header('Location: /shop/' . $_POST['shop']);
			die();
		}

		if (!isset($_POST['quantity'])) {
			// no quantity
			$_SESSION['meal_alert'] = '尚未選擇餐點數量';
			header('Location: /meal/' . $_POST['meal']);
			die();
		}

		if ($_POST['meal'] != $param) {
			// POST 的 meat id 參數與網址不同
			header('Location: /shop/' . $_POST['shop']);
			die();
		}

		$shop = shop::get_single($_POST['shop']);

		if ($_SESSION['place']['area'] != $shop['area_id']) {
			// shop not in this area
			header('Location: /shop');
			die();
		}

		if ($shop['status'] != '1') {
			$_SESSION['meal_alert'] = '此店家目前未營業，暫未開放點餐';
			header('Location: /meal/' . $param);
			die();
		}

		$meal = meal::get_single($param);

		if (!isset($meal['status'])) {
			$_SESSION['meal_alert'] = '無此餐點，請選擇其他餐點';
			header('Location: /shop');
			die();
		}

		if ($meal['status'] != '1') {
			$_SESSION['meal_alert'] = '目前未提供此餐點，請選擇其他餐點';
			header('Location: /meal/' . $param);
			die();
		}

		if (isset($_SESSION['car']['shop'])) {
			if ($shop['id'] != $_SESSION['car']['shop']) {
				$_SESSION['meal_alert'] = '目前購物車中尚有其他店家的餐點，故無法新增此餐點，請先至購物車移除其他餐點後，方可新增此餐點';
				header('Location: /meal/' . $param);
				die();
			}
		}

		if ($_POST['quantity'] > ITEM_MAX_BUY) {
			$_SESSION['meal_alert'] = '餐點數量超過購買上限';
			header('Location: /meal/' . $param);
			die();
		}

		echo $_SESSION['car']['shop'];
		echo $shop['id'];

		$_SESSION['car']['shop'] = $shop['id'];

		if (!isset($_SESSION['car']['meal'])) {
			$_SESSION['car']['meal'] = array();
		}


		$find = false;
		$index = 0;
		foreach ($_SESSION['car']['meal'] as $i => $item) {
			if ($item['id'] == $meal['id']) {
				$find = true;
				$index = $i;
				break;
			}
		}

		if ($find) {
			$_SESSION['car']['total_meal'] += ($_POST['quantity'] - $_SESSION['car']['meal'][$index]['quantity']);
			$_SESSION['car']['meal'][$index]['id'] = $meal['id'];
			$_SESSION['car']['meal'][$index]['quantity'] = $_POST['quantity'];
			$_SESSION['car']['meal'][$index]['note'] = $_POST['note'];
			$_SESSION['shop_alert'] = '已更新餐點至購物車中';
		} else {
			if (isset($_SESSION['car']['total_meal'])) {
				$_SESSION['car']['total_meal'] += $_POST['quantity'];
			} else {
				$_SESSION['car']['total_meal'] = $_POST['quantity'];
			}
			$add_meal['id'] = $meal['id'];
			$add_meal['quantity'] = $_POST['quantity'];
			$add_meal['note'] = $_POST['note'];

			array_push($_SESSION['car']['meal'], $add_meal);
			$_SESSION['shop_alert'] = '已新增餐點至購物車中';
		}

		header('Location: /shop/' . $shop['id']);
	}
}