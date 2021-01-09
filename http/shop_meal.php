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

class shop_meal {
	public function __construct($param) {
		if (empty($_SESSION['place']['selected'])) {
			header('Location: /place');
			die();
		}

		$shop = shop::get_single($param);

		if (empty($shop['name'])) {
			header('Location: /shop');
			die();
		}

		if ($_SESSION['place']['area'] != $shop['area_id']) {
			// shop not in this area
			header('Location: /shop');
			die();
		}

		if (!isset($_SESSION['user']['id'])) {
			if (!isset($_SESSION['shop_alert'])) {
				$_SESSION['shop_alert'] = '登入後方可開始點餐';
			}
		}


		// `id`, `name`, `price`, `status`, `note`
		$meal = meal::shop_all($param);
		$meals = array();

		foreach (meal::shop_all($param) as $item) {
			$find = false;
			$quantity = 0;
			if (isset($_SESSION['car']['meal'])) {
				foreach ($_SESSION['car']['meal'] as $item2) {
					if ($item['id'] == $item2['id']) {
						$find = true;
						$quantity = $item2['quantity'];
						break;
					}
				}
			}
			$the_meal['id'] = $item['id'];
			$the_meal['name'] = $item['name'];
			$the_meal['price'] = $item['price'];
			$the_meal['status'] = $item['status'];
			$the_meal['note'] = $item['note'];
			$the_meal['quantity'] = $quantity;
			array_push($meals, $the_meal);
		}

		view::func('shop/meal', function () use ($param, $shop, $meals) {
			return ['area' => area::get_name($_SESSION['place']['area']),
				'build' => build::get_name($_SESSION['place']['build']), 'shop' => $shop, 'meal' => $meals];
		});
	}
}