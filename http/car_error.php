<?php

use view\view;

class car_error {
	public function __construct() {
		if(!isset($_SESSION['car_error'])) {
			header('Location: /car');
		}

		view::arr('car/error', [
		]);
	}
}