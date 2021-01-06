<?php

use database\area;
use database\build;
use database\shop;
use view\view;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/shop.php';

class shop_list {
	public function __construct() {
		if(empty($_SESSION['place']['selected'])) {
			header('Location: /place');
		}

		view::func('shop/list', function () {
			return [
				'area' => area::get_name($_SESSION['place']['area']),
				'build' => build::get_name($_SESSION['place']['build']),
				'shop' => shop::area_all($_SESSION['place']['area'])
			];
		});
	}
}