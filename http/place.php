<?php

use database\area;
use view\view;

require_once FOLDER_PATH . 'database/area.php';

class place {
	public function __construct() {
		view::func('place/place', function () {
			return [
				'area' => area::all()
			];
		});
	}
}