<?php

use database\area;
use view\view;

require_once FOLDER_PATH . 'database/area.php';

class place {
	public function __construct() {
		unset($_SESSION['place']['selected']);
		unset($_SESSION['place']['area']);
		unset($_SESSION['place']['build']);
		unset($_SESSION['place']['room']);
		view::func('place/place', function () {
			return [
				'area' => area::all()
			];
		});
	}
}