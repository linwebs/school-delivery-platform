<?php

namespace view;

class view {
	public static function view($view) {
		if (!@include_once FOLDER_PATH . 'view/' . $view . '.php') {
			view::view('error_500');
		}
	}

	public static function arr($view, $data) {
		if (!@include_once FOLDER_PATH . 'view/' . $view . '.php') {
			view::view('error_500');
		}
	}

	public static function func($view, $data) {
		$data = $data();
		if (!@include_once FOLDER_PATH . 'view/' . $view . '.php') {
			view::view('error_500');
		}
	}

	public static function img_jpg($path, $file) {
		$file_path = FOLDER_PATH . 'storage/img/' . $path . '/' . $file . '.jpg';
		$file_name = $file;
		$type = 'image/jpeg';

		if (file_exists($file_path)) {
			header('Content-Disposition: inline; filename="' . $file_name . '"');
			header('Content-Type:' . $type);
			header('Content-Length: ' . filesize($file_path));
			return file_get_contents($file_path);
		} else {
			return false;
		}
	}

	public static function img_png($path, $file) {
		$file_path = FOLDER_PATH . 'storage/img/' . $path . '/' . $file . '.png';
		$file_name = $file;
		$type = 'image/png';

		if (file_exists($file_path)) {
			header('Content-Disposition: inline; filename="' . $file_name . '"');
			header('Content-Type:' . $type);
			header('Content-Length: ' . filesize($file_path));
			return file_get_contents($file_path);
		} else {
			return false;
		}
	}

	public static function img($path, $file) {

		$file_path = FOLDER_PATH . 'storage/img/' . $path . '/' . $file;
		$file_name = $file;
		$type = 'image/jpeg';

		if (file_exists($file_path)) {
			header('Content-Disposition: inline; filename="' . $file_name . '"');
			header('Content-Type:' . $type);
			header('Content-Length: ' . filesize($file_path));
			readfile($file_path);
			return true;
		} else {
			return false;
		}
	}
}