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

	public static function get_name($id) {
		$sql = 'SELECT `name` FROM `place_build` WHERE `id` = :id';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC)['name'];
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_single_from_id_area_id($id, $area) {
		$sql = 'SELECT `place_build`.`id` AS `build_id`, `place_area`.`id` AS `area_id` FROM `place_build`, `place_area` WHERE `place_build`.`area_id` = `place_area`.`id` AND `place_build`.`id` = :build AND `place_area`.`id` = :area';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':build', $id, PDO::PARAM_INT);
			$stmt->bindValue(':area', $area, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}
}