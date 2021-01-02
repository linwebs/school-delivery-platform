<?php

namespace database;

use PDO;
use PDOException;

require_once FOLDER_PATH . 'database/connect.php';


class build {
	public static function area_all($area) {
		$sql = 'SELECT `place_build`.`id`, `place_build`.`name` FROM `place_area`, `place_build` WHERE `place_build`.`area_id` = :area AND `place_area`.`id` = `place_build`.`area_id`';
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