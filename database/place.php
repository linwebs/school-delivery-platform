<?php

namespace database;

use PDO;
use PDOException;

require_once FOLDER_PATH . 'database/connect.php';

class place {
	public static function get_single_room($id) {
		$sql = 'SELECT `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM `place_room`, `place_build`, `place_area` WHERE `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id` AND `place_room`.`id` = :id';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_user_all($user) {
		$sql = 'SELECT `user_place`.`id` AS `user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM `user_place`, `place_room`, `place_build`, `place_area` WHERE `user_place`.`user_id` = :user AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id`';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':user', $user, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_user_single($user, $id) {
		$sql = 'SELECT `user_place`.`id` AS `user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`id` AS `room_id`, `place_room`.`name` AS `room_name`, `place_build`.`id` AS `build_id`, `place_build`.`name` AS `build_name`, `place_area`.`id` AS `area_id`, `place_area`.`name` AS `area_name` FROM `user_place`, `place_room`, `place_build`, `place_area` WHERE `user_place`.`user_id` = :user AND `user_place`.`id` = :id AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id`';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':user', $user, PDO::PARAM_INT);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_my_place_id($my) {
		$sql = 'SELECT `place_id` FROM `user_place` WHERE `id` = :id';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $my, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function add_user_place($user, $place, $name, $detail) {
		$sql = 'INSERT INTO `user_place` (`id`, `user_id`, `place_id`, `name`, `detail`) VALUES (NULL, :user, :place, :name, :detail)';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':user', $user, PDO::PARAM_INT);
			$stmt->bindValue(':place', $place, PDO::PARAM_INT);
			$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->bindValue(':detail', $detail, PDO::PARAM_STR);
			$stmt->execute();
			return $conn->lastInsertId();
		} catch (PDOException $exception) {
			die('DB INSERT Error: ' . $exception);
		}
	}

	public static function update_user_place($id, $name, $detail) {
		$sql = 'UPDATE `user_place` SET `name` = :name, `detail` = :detail WHERE `user_place`.`id` = :id';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->bindValue(':detail', $detail, PDO::PARAM_STR);
			return $stmt->execute();
		} catch (PDOException $exception) {
			die('DB INSERT Error: ' . $exception);
		}
	}
}