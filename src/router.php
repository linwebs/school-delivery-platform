<?php
// 使用 router 命名空間
namespace router;

class router {
	// 以陣列方式傳回網址目錄
	public static function locale() {
		$request      = $_SERVER['REQUEST_URI'];
		$original_uri = explode('?', $request, 2);
		$locale       = explode('/', $original_uri[0]);
		$data         = array();
		foreach($locale as $item) {
			if(!empty($item)) {
				$items = urldecode($item);
				array_push($data, $items);
			}
		}
		return $data;
	}

	public static function locale_sub($url) {
		$request      = substr($_SERVER['REQUEST_URI'], strlen($url));
		$original_uri = explode('?', $request, 2);
		$locale       = explode('/', $original_uri[0]);
		$data         = array();
		foreach($locale as $item) {
			if(!empty($item)) {
				$items = urldecode($item);
				array_push($data, $items);
			}
		}
		return $data[0];
	}

	// 已陣列方式傳回網址 GET 請求內容
	public static function data() {
		$request      = $_SERVER['REQUEST_URI'];
		$original_uri = explode('?', $request, 2);
		// GET 欄位有內容的處理方式
		if(!empty($original_uri[1])) {
			if(strpos($original_uri[1], '=')) {
				// GET 欄位有資料的處理方式 EX: /?page=index
				$uri_data = explode('&', $original_uri[1]);
				$data     = array();

				foreach($uri_data as $items) {
					$item        = explode('=', $items, 2);
					$name        = urldecode($item[0]);
					$value       = urldecode($item[1]);
					$data[$name] = $value;
				}
			} else {
				// GET 欄位沒資料的處理方式 EX: /?page
				$data = $original_uri[1];
				$data = urldecode($data);
			}
			return $data;
		} else {
			// GET 欄位完全沒內容的處理方式 EX: /
			return array();
		}
	}
}