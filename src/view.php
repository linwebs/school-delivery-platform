<?php

namespace view;

class view {
	public static function view($view) {
		require_once FOLDER_PATH . 'view/' . $view . '.php';
	}
}