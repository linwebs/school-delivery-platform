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
		if(empty($_SESSION['place']['selected'])) {
			header('Location: /place');
		}

		$_SESSION['shop']['last_view_id'] = $param;
		view::func('shop/meal', function () use ($param) {
			return [
				'area' => area::get_name($_SESSION['place']['area']),
				'build' => build::get_name($_SESSION['place']['build']),
				'shop' => shop::get_single($param),
				'meal' => meal::shop_all($param)
			];
		});
	}
}