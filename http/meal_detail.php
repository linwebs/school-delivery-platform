<?php

use database\area;
use database\build;
use database\meal;
use database\shop;
use view\view;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/shop.php';
require_once FOLDER_PATH . 'database/meal.php';

class meal_detail {
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

		$meal = meal::get_single($param);

		if ($meal['status'] != '1') {
			$_SESSION['meal_alert'] = '目前未提供此餐點，請選擇其他餐點';
		}

		if (!isset($_SESSION['user']['id'])) {
			if (!isset($_SESSION['meal_alert'])) {
				$_SESSION['meal_alert'] = '登入後方可開始點餐';
			}
		}

		$quantity = 0;
		$note = '';
		if (isset($_SESSION['car']['meal'])) {
			foreach ($_SESSION['car']['meal'] as $i => $item) {
				if ($item['id'] == $meal['id']) {
					$quantity = $item['quantity'];
					$note = $item['note'];
					break;
				}
			}
		}

		view::func('meal/detail', function () use ($param, $meal, $quantity, $note) {
			return [
				'area' => area::get_name($_SESSION['place']['area']),
				'build' => build::get_name($_SESSION['place']['build']),
				'shop' => shop::get_single($meal['shop_id']),
				'meal' => $meal, 'quantity' => $quantity,
				'note' => $note
			];
		});
	}
}