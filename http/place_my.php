<?php

use database\area;
use view\view;

require_once FOLDER_PATH . 'database/area.php';

class place_my {
	public function __construct($param) {
		print_r($param);
		/*
		view::func('place', function () {
			return [
				'area' => area::all()
			];
		});*/
	}
}