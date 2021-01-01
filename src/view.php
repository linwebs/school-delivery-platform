<?php

namespace view;

class view {
	public static function other($view) {
		require_once FOLDER_PATH . 'view/' . $view . '.php';
	}
}