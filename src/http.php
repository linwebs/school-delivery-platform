<?php

namespace http;

use view\view;

class http {
	public static function http($http) {
		if(@include_once FOLDER_PATH . 'http/' . $http . '.php') {
			new $http();
		} else {
			view::view('error_500');
		}
	}

	public static function param($http, $param) {
		if(@include_once FOLDER_PATH . 'http/' . $http . '.php') {
			new $http($param);
		} else {
			view::view('error_500');
		}
	}
}