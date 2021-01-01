<?php

namespace route;

use view\view;

require_once FOLDER_PATH . 'src/view.php';

class route {
	public static function get($path, $view) {
		if($path == $_SERVER['REQUEST_URI']) {
			view::other($view);
			global $SHOW_PAGE;
			$SHOW_PAGE = true;
		}
	}

	public static function no_page() {
		if(isset($SHOW_PAGE)) {
			if($SHOW_PAGE == true) {
				exit();
			}
		}
		view::other('error_404');
	}
}