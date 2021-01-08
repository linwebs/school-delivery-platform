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
		$img = $this->get_locale();
		if(!$img) {
			view::view('error_404');
		} else {
			echo $img;
		}
	}

	private function get_locale() {
		if (!isset(router::locale()[1])) {
			return false;
		}
		switch (router::locale()[1]) {
			case 'area':
				return $this->get_area();
			case 'shop':
				return $this->get_shop();
			case 'meal':
				return $this->get_meal();
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

	private function get_shop() {
		if (!isset(router::locale()[2])) {
			return false;
		}
		if(view::img_jpg('shop', router::locale()[2])) {
			return view::img_jpg('shop', router::locale()[2]);
		} else {
			return view::img_png('shop', 'noshop');
		}
	}

	private function get_meal() {
		if (!isset(router::locale()[2])) {
			return false;
		}
		if(view::img_jpg('meal', router::locale()[2])) {
			return view::img_jpg('meal', router::locale()[2]);
		} else {
			return view::img_png('meal', 'nomeal');
		}
	}
}

new img();