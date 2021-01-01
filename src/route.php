<?php

namespace route;

use http\http;
use view\view;

require_once FOLDER_PATH . 'src/view.php';
require_once FOLDER_PATH . 'src/http.php';

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

	public static function geth($path, $http) {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if ($path == $_SERVER['REQUEST_URI']) {
				http::http($http);
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