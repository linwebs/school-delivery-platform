<?php

namespace view;

class view {
	public static function view($view) {
		require_once FOLDER_PATH . 'view/' . $view . '.php';
	}

	public static function arr($view, $data) {
		require_once FOLDER_PATH . 'view/' . $view . '.php';
	}

	public static function func($view, $data) {
		$data = $data();
		require_once FOLDER_PATH . 'view/' . $view . '.php';
	}

	public static function img_jpg($path, $file) {
		$file_path = FOLDER_PATH . 'storage/img/' . $path . '/' . $file . '.jpg';
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