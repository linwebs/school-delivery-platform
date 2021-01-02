<?php

namespace database;

use PDO;
use PDOException;

require_once FOLDER_PATH . 'database/connect.php';

class area {
	public static function all() {
		$sql = 'SELECT `id`, `name` FROM `place_area`';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_name($id) {
		$sql = 'SELECT `id`, `name` FROM `place_area` WHERE `id` = :id';
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
}