<?php

use database\build;
use database\room;
use view\view;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/room.php';

class place_add_finish {
	public function __construct() {
		/*
		echo ' area: ';
		print_r(router\router::locale()[2]);
		echo ' build: ';
		echo $_POST['build'];
		echo ' room: ';
		echo $_POST['room'];
		*/
		$_SESSION['place']['selected'] = true;
		$_SESSION['place']['area'] = router\router::locale()[2];
		$_SESSION['place']['build'] = $_POST['build'];
		$_SESSION['place']['room'] = $_POST['room'];

		header('Location: /shop');
	}
}