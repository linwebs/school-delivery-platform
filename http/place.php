<?php

use database\area;
use view\view;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/place.php';

class place {
	public function __construct() {
		unset($_SESSION['place']['selected']);
		unset($_SESSION['place']['area']);
		unset($_SESSION['place']['build']);
		unset($_SESSION['place']['room']);

		if(isset($_SESSION['user']['id'])) {
			$my = \database\place::get_user_all($_SESSION['user']['id']);
		} else {
			$my = array();
		}

		view::func('place/place', function () use ($my) {
			return [
				'area' => area::all(),
				'my' => $my
			];
		});
	}
}