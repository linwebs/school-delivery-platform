<?php


class meal_add {
	public function __construct($param) {
		if(empty($_SESSION['place']['selected'])) {
			header('Location: /place');
		}

		echo 'meal add: ' . $param . '<br>';
		echo 'shop id: ' . $_SESSION['shop']['last_view_id'];
	}
}