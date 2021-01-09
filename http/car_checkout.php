<?php


class car_checkout {
	public function __construct() {
		if(empty($_SESSION['place']['selected'])) {
			header('Location: /place');
			die();
		}

		echo 'checkout' . '<br>';
		echo 'place name: ' . $_POST['place_name'] . '<br>';
		echo 'place detail: ' . $_POST['place_detail'] . '<br>';
		echo 'order detail: ' . $_POST['order_detail'] . '<br>';
	}
}