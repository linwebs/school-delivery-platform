<?php

namespace database;

use PDO;
use PDOException;

require_once FOLDER_PATH . 'database/connect.php';


class room {
	public static function area_all($area) {
		$sql = 'SELECT `place_room`.`id`, `place_room`.`build_id`, `place_room`.`name` FROM `place_area`, `place_build`, `place_room` WHERE `place_build`.`area_id` = :area AND `place_area`.`id` = `place_build`.`area_id` AND `place_room`.`build_id` = `place_build`.`id` ORDER BY `place_room`.`build_id` ASC';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':area', $area, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

}