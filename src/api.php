<?php

namespace api;

class api {
	public static function api($api) {
		require_once FOLDER_PATH . 'api/' . $api . '.php';
		new $api();
	}

	public static function param($api, $param) {
		require_once FOLDER_PATH . 'api/' . $api . '.php';
		new $api($param);
	}
}