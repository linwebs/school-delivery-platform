<?php

use view\view;

class shop_list {
	public function __construct() {
		if(empty($_SESSION['locale_area'])) {
			header('Location: /place');
		}

		view::func('shop/list', function () {
			return [
				'abc' => '123',
				'def' => '456'
			];
		});
	}
}