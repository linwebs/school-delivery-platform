<?php

use database\build;
use database\room;
use view\view;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/room.php';

class place_add_finish {
	public function __construct() {
		echo ' area: ';
		print_r(router\router::locale()[2]);
		echo ' build: ';
		echo $_POST['build'];
		echo ' room: ';
		echo $_POST['room'];
	}
}