<?php

use database\build;
use database\room;
use view\view;

require_once FOLDER_PATH . 'database/area.php';
require_once FOLDER_PATH . 'database/build.php';
require_once FOLDER_PATH . 'database/room.php';

class place_add {
	public function __construct($param) {
		view::arr('place/place_add', [
			'area' => $param,
			'build' => build::area_all($param),
			'room' => $this->room_format($param)
		]);
	}

	private function room_format($param) {
		$first = true;
		$last_build = 0;
		$room = room::area_all($param);
		if (empty($room)) {
			return '[]';
		}
		$result = '';
		foreach ($room as $item) {
			if ($last_build != $item['build_id']) {
				if ($first) {
					$result .= '[{"build":' . $item['build_id'] . ', "room": [';
					$first = false;
				} else {
					$result .= ']},{"build":' . $item['build_id'] . ', "room": [';
				}
				$last_build = $item['build_id'];
			}
			$result .= '{"id":' . $item['id'] . ',"name":"' . $item['name'] . '"},';
		}
		$result .= ']}]';
		return $result;
	}
}