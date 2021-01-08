<?php

namespace database;

use PDO;
use PDOException;

require_once FOLDER_PATH . 'database/connect.php';

class meal {
	public static function shop_all($shop) {
		$sql = 'SELECT `meal`.`id`, `meal`.`name`, `meal`.`price`, `meal`.`status`, `meal`.`note` FROM `meal` WHERE `meal`.`shop_id` = :shop';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':shop', $shop, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}
}