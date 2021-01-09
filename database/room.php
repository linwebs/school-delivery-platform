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

	public static function get_room_from_name_build_id_area_id($room, $build, $area) {
		$sql = 'SELECT `place_room`.`id` AS `place_room_id`, `place_room`.`name` AS `place_room_name`, `place_build`.`id` AS `build_id`, `place_build`.`area_id` FROM `place_room`, `place_build` WHERE `place_room`.`name` = :room AND `place_room`.`build_id` = :build AND `place_build`.`area_id` = :area AND `place_room`.`build_id` = `place_build`.`id`';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':build', $build, PDO::PARAM_INT);
			$stmt->bindValue(':area', $area, PDO::PARAM_INT);
			$stmt->bindValue(':room', $room, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function add_room($build, $name) {
		$sql = 'INSERT INTO `place_room` (`id`, `build_id`, `name`) VALUES (NULL, :build, :name)';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':build', $build, PDO::PARAM_INT);
			$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->execute();
			return $conn->lastInsertId();
		} catch (PDOException $exception) {
			die('DB INSERT Error: ' . $exception);
		}
	}
}