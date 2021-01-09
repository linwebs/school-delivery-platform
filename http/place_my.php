<?php

use database\area;
use database\place;
use view\view;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/place.php';

class place_my {
	public function __construct($param) {
		if (!isset($_SESSION['user']['id'])) {
			header('Location: /login');
			die();
		}

		//print_r($param);

		$my = place::get_user_single($_SESSION['user']['id'], $param);

		if(isset($my['user_place_id'])) {
			$_SESSION['place']['selected'] = true;
			$_SESSION['place']['area'] = $my['area_id'];
			$_SESSION['place']['build'] = $my['build_id'];
			$_SESSION['place']['room'] = $my['room_name'];
			$_SESSION['place']['my'] = $my['user_place_id'];
			header('Location: /shop');
		} else {
			// user place error
			header('Location: /place');
		}
	}
}