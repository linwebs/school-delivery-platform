<?php

namespace api;

use view\view;

class api {
	public static function api($api) {
		if(@include_once FOLDER_PATH . 'api/' . $api . '.php') {
			new $api();
		} else {
			view::view('error_500');
		}
	}

	public static function param($api, $param) {
		if(@include_once FOLDER_PATH . 'api/' . $api . '.php') {
			new $api($param);
		} else {
			view::view('error_500');
		}
	}
}