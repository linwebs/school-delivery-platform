<?php

use database\area;
use database\build;
use database\meal;
use database\shop;
use database\place;
use view\view;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/shop.php';
require_once FOLDER_PATH . 'database/meal.php';
require_once FOLDER_PATH . 'database/place.php';

class car {
	public function __construct() {
		if (empty($_SESSION['place']['selected'])) {
			header('Location: /place');
			die();
		}

		if (!isset($_SESSION['car'])) {
			$car['shop'] = '';
			$car['meal'] = array();
		} elseif (!isset($_SESSION['car']['meal'])) {
			$car['shop'] = $_SESSION['car']['shop'];
			$car['meal'] = array();
		} else {
			$car['shop'] = $_SESSION['car']['shop'];
			$car['meal'] = array();
			foreach ($_SESSION['car']['meal'] as $item) {
				if (isset($item['id'])) {
					$db_meal = meal::get_single($item['id']);
					if ($db_meal) {
						$meal['id'] = $db_meal['id'];
						$meal['name'] = $db_meal['name'];
						$meal['price'] = $db_meal['price'];
						$meal['status'] = $db_meal['status'];
						$meal['quantity'] = $item['quantity'];
						$endl = array('\n', '\r\n', '\r', '<br>', '<br/>', '<br />');
						$meal['note'] = str_replace($endl, " ", $item['note']);
						array_push($car['meal'], $meal);
					}
				}
			}
		}

		$shop = shop::get_single($car['shop']);

		$price_meals = 0;
		if(isset($_SESSION['car']['meal'])) {
			foreach ($_SESSION['car']['meal'] as $item) {
				$price_meals += $item['quantity'] * (meal::get_single($item['id'])['price']);
			}
		}
		$price_total = $price_meals + DELIVERY_FEE;

		if (isset($shop['status'])) {
			if ($shop['status'] != '1') {
				if (!isset($_SESSION['car_alert'])) {
					$_SESSION['car_alert'] = '此店家目前未營業，暫未開放點餐';
				}
			}
		}

		if($_SESSION['place']['my'] == false) {
			$place['name'] = '我的新地點';
			$place['note'] = '';
		} else {
			$my_place = place::get_user_single($_SESSION['user']['id'], $_SESSION['place']['my']);
			$place['name'] = $my_place['user_place_name'];
			$place['note'] = $my_place['user_place_detail'];
		}

		view::func('car/car', function () use ($place, $shop, $car, $price_meals, $price_total) {
			return [
				'place' => $place,
				'area' => area::get_name($_SESSION['place']['area']),
				'build' => build::get_name($_SESSION['place']['build']),
				'shop' => $shop,
				'car' => $car,
				'price-meals' => $price_meals,
				'price-delivery' => DELIVERY_FEE,
				'price-total' => $price_total
			];
		});
	}
}