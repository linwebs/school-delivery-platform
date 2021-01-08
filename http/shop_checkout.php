<?php


class shop_checkout {
	public function __construct() {
		if(empty($_SESSION['place']['selected'])) {
			header('Location: /place');
		}

		echo 'checkout';
	}
}