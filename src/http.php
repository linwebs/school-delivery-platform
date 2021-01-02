<?php

namespace http;

class http {
	public static function http($http) {
		require_once FOLDER_PATH . 'http/' . $http . '.php';
		new $http();
	}

	public static function param($http, $param) {
		require_once FOLDER_PATH . 'http/' . $http . '.php';
		new $http($param);
	}
}