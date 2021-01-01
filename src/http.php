<?php

namespace http;

class http {
	public static function http($http) {
		require_once FOLDER_PATH . 'http/' . $http . '.php';
	}
}