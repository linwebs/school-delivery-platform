<?php

namespace api;

use database\meal;

require_once FOLDER_PATH . 'database/meal.php';

class car_meal_add {
	public function __construct($id) {
		$error = false;
		$quantity = 0;
		$price = 0;
		if (!isset($_SESSION['car'])) {
			// no shop car
			$error = "目前購物車中尚無任何餐點";
		} elseif (!isset($_SESSION['car']['meal'])) {
			$error = "目前購物車中尚無任何餐點";
		} else {
			$find = false;
			foreach ($_SESSION['car']['meal'] as $i => $item) {
				if ($item['id'] == $id) {
					$find = true;
					if ($item['quantity'] + 1 > ITEM_MAX_BUY) {
						$error = "餐點數量已達購買上限";
					} else {
						$_SESSION['car']['meal'][$i]['quantity']++;
						$_SESSION['car']['total_meal']++;
						$quantity = $_SESSION['car']['meal'][$i]['quantity'];
						$meal = meal::get_single($item['id']);
						$price = $meal['price'];
					}
					break;
				}
			}
			if (!$find) {
				$error = "購物車中無此餐點";
			}
		}

		if ($error) {
			$json = '{"status": false, "msg": "' . $error . '"}';
		} else {

			$price_meals = 0;
			foreach ($_SESSION['car']['meal'] as $item) {
				$price_meals += $item['quantity'] * (meal::get_single($item['id'])['price']);
			}
			$price_total = $price_meals + DELIVERY_FEE;

			$total_meal = $_SESSION['car']['total_meal'];

			$json = '{"status": true, "quantity": ' . $quantity . ', "price": ' . $quantity * $price . ', "price_meals": ' . $price_meals . ', "price_delivery": ' . DELIVERY_FEE . ', "price_total": ' . $price_total . ', "total_meal": ' . $total_meal . '}';
		}
		echo $json;
	}
}