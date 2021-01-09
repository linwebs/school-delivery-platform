<?php

namespace database;

use PDO;
use PDOException;

require_once FOLDER_PATH . 'database/connect.php';

class order {
	public static function add_order($user, $shop, $place, $note) {
		$sql = 'INSERT INTO `user_order` (`id`, `user_id`, `shop_id`, `user_place_id`, `delivery_id`, `note`, `status`, `order_time`) VALUES (NULL, :user, :shop, :place, NULL, :note, :status, CURRENT_TIMESTAMP)';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':user', $user, PDO::PARAM_INT);
			$stmt->bindValue(':shop', $shop, PDO::PARAM_INT);
			$stmt->bindValue(':place', $place, PDO::PARAM_INT);
			$stmt->bindValue(':note', $note, PDO::PARAM_STR);
			$stmt->bindValue(':status', 1, PDO::PARAM_INT);
			$stmt->execute();
			return $conn->lastInsertId();
		} catch (PDOException $exception) {
			die('DB INSERT Error: ' . $exception);
		}
	}

	public static function add_order_meal($order, $meal, $quantity, $note) {
		$sql = 'INSERT INTO `order_meal` (`id`, `order_id`, `meal_id`, `quantity`, `note`) VALUES (NULL, :order, :meal, :quantity, :note);';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':order', $order, PDO::PARAM_INT);
			$stmt->bindValue(':meal', $meal, PDO::PARAM_INT);
			$stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
			$stmt->bindValue(':note', $note, PDO::PARAM_STR);
			$stmt->execute();
			return $conn->lastInsertId();
		} catch (PDOException $exception) {
			die('DB INSERT Error: ' . $exception);
		}
	}
}