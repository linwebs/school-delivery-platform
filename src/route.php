<?php

namespace route;

use api\api;
use http\http;
use view\view;

require_once FOLDER_PATH . 'src/view.php';
require_once FOLDER_PATH . 'src/http.php';
require_once FOLDER_PATH . 'src/api.php';

class route {
	public static function get($path, $view) {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if ($path == $_SERVER['REQUEST_URI']) {
				view::view($view);
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function gethp($path, $http) {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if (!isset($_SERVER['REQUEST_URI'][strlen($path)])) {
				return;
			}
			if ($path == substr($_SERVER['REQUEST_URI'], 0, strlen($path)) && $_SERVER['REQUEST_URI'][strlen($path)] == '/') {
				http::param($http, substr($_SERVER['REQUEST_URI'], strlen($path) + 1));
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function geth($path, $http) {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if ($path == $_SERVER['REQUEST_URI']) {
				http::http($http);
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function geta($path, $api) {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if ($path == $_SERVER['REQUEST_URI']) {
				api::api($api);
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function getap($path, $api) {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if (!isset($_SERVER['REQUEST_URI'][strlen($path)])) {
				return;
			}
			if ($path == substr($_SERVER['REQUEST_URI'], 0, strlen($path)) && $_SERVER['REQUEST_URI'][strlen($path)] == '/') {
				api::param($api, substr($_SERVER['REQUEST_URI'], strlen($path) + 1));
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function getp($path, $http) {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if (!isset($_SERVER['REQUEST_URI'][strlen($path)])) {
				return;
			}
			if ($path == substr($_SERVER['REQUEST_URI'], 0, strlen($path)) && $_SERVER['REQUEST_URI'][strlen($path)] == '/') {
				http::param($http, substr($_SERVER['REQUEST_URI'], strlen($path) + 1));
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function getpn($path, $http, $not) {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if (!isset($_SERVER['REQUEST_URI'][strlen($path)])) {
				return;
			}
			if(in_array(substr($_SERVER['REQUEST_URI'], strlen($path) + 1), $not)) {
				return;
			}
			if ($path == substr($_SERVER['REQUEST_URI'], 0, strlen($path)) && $_SERVER['REQUEST_URI'][strlen($path)] == '/') {
				http::param($http, substr($_SERVER['REQUEST_URI'], strlen($path) + 1));
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function post($path, $http) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($path == $_SERVER['REQUEST_URI']) {
				http::http($http);
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function postp($path, $http) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!isset($_SERVER['REQUEST_URI'][strlen($path)])) {
				return;
			}
			if ($path == substr($_SERVER['REQUEST_URI'], 0, strlen($path)) && $_SERVER['REQUEST_URI'][strlen($path)] == '/') {
				http::param($http, substr($_SERVER['REQUEST_URI'], strlen($path) + 1));
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function postpn($path, $http, $not) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!isset($_SERVER['REQUEST_URI'][strlen($path)])) {
				return;
			}
			if(in_array(substr($_SERVER['REQUEST_URI'], strlen($path) + 1), $not)) {
				return;
			}
			if ($path == substr($_SERVER['REQUEST_URI'], 0, strlen($path)) && $_SERVER['REQUEST_URI'][strlen($path)] == '/') {
				http::param($http, substr($_SERVER['REQUEST_URI'], strlen($path) + 1));
				global $SHOW_PAGE;
				$SHOW_PAGE = true;
			}
		}
	}

	public static function no_page() {
		global $SHOW_PAGE;
		if (isset($SHOW_PAGE)) {
			if ($SHOW_PAGE == true) {
				exit();
			}
		}
		view::view('error_404');
	}
}