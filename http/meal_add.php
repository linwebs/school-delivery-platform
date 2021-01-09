<?php


use database\area;
use database\build;
use database\meal;
use database\shop;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/shop.php';
require_once FOLDER_PATH . 'database/meal.php';

class meal_add {
	public function __construct($param) {
		if (empty($_SESSION['place']['selected'])) {
			header('Location: /place');
		}
		echo 'mead add' . '<br>';
		echo 'shop: ' . $_POST['shop'] . '<br>';
		echo 'last shop: ' . $_SESSION['shop']['last_view_id'] . '<br>';
		echo 'meal: ' . $_POST['meal'] . '<br>';
		echo 'meal param: ' . $param . '<br>';
		echo 'quantity: ' . $_POST['quantity'] . '<br>';
		echo 'note: ' . $_POST['note'] . '<br>';

		/*
				view::func('meal/detail', function () use ($param) {
					return [
						'area' => area::get_name($_SESSION['place']['area']),
						'build' => build::get_name($_SESSION['place']['build']),
						'shop' => shop::get_single($_SESSION['shop']['last_view_id']),
						'meal' => meal::get_single($param)
					];
				});*/
	}
}