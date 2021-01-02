<?php

use route\route;
use router\router;
use view\view;

class img {
	private string $level1;
	private string $level2;

	public function __construct() {
		$this->level1 = '';
		$this->level2 = '';
		if(!$this->get_locale()) {
			view::view('error_404');
		}
	}

	private function get_locale() {
		if (!isset(router::locale()[1])) {
			return false;
		}
		switch (router::locale()[1]) {
			case 'area':
				return $this->get_area();
			case 'main':
				return $this->get_main();
			default:
				return false;
		}
	}

	private function get_main() {
		if (!isset(router::locale()[2])) {
			return false;
		}
		return view::img('main', router::locale()[2]);
	}

	private function get_area() {
		if (!isset(router::locale()[2])) {
			return false;
		}
		return view::img_jpg('area', router::locale()[2]);
	}
}

new img();