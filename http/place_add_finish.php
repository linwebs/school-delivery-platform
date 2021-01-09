<?php

class place_add_finish {
	public function __construct() {
		$_SESSION['place']['selected'] = true;
		$_SESSION['place']['area'] = router\router::locale()[2];
		$_SESSION['place']['build'] = $_POST['build'];
		$_SESSION['place']['room'] = $_POST['room'];
		$_SESSION['place']['my'] = false;

		header('Location: /shop');
	}
}