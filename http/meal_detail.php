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
		if(empty($_SESSION['place']['selected'])) {
			header('Location: /place');
		}

		view::func('meal/detail', function () use ($param) {
			return [
				'area' => area::get_name($_SESSION['place']['area']),
				'build' => build::get_name($_SESSION['place']['build']),
				'shop' => shop::get_single($_SESSION['shop']['last_view_id']),
				'meal' => meal::get_single($param)
			];
		});
	}
}