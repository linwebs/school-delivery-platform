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

	public static function get_user_order($user) {

		$ticket_status = implode(",", TICKET_STATUS_ACTIVE);
		$sql = 'SELECT `order`.`id` AS `order_id`, `order`.`status` AS `order_status`, `order`.`order_time`, `order`.`note` AS `order_note`, `shop`.`id` AS `shop_id`, `shop`.`name` AS `shop_name`, `delivery`.`name` AS `delivery_name`, `order`.`user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM ( `user_order` AS `order` LEFT JOIN `user` AS `delivery` ON `order`.`delivery_id` = `delivery`.`id` ), `shop`, `user_place`, `place_room`, `place_build`, `place_area` WHERE `order`.`user_id` = :user AND `order`.`shop_id` = `shop`.`id` AND `order`.`user_place_id` = `user_place`.`id` AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id` AND `order`.`status` IN (' . $ticket_status . ') ORDER BY `order_status` DESC, `order_time` DESC';
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

	public static function get_user_single_order($user, $id) {
		$sql = 'SELECT `order`.`id` AS `order_id`, `order`.`user_id` AS `user_id`, `order`.`status` AS `order_status`, `order`.`order_time`, `order`.`note` AS `order_note`, `shop`.`id` AS `shop_id`, `shop`.`name` AS `shop_name`, `delivery`.`name` AS `delivery_name`, `delivery`.`phone` AS `delivery_phone`, `order`.`user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM ( `user_order` AS `order` LEFT JOIN `user` AS `delivery` ON `order`.`delivery_id` = `delivery`.`id` ), `shop`, `user_place`, `place_room`, `place_build`, `place_area` WHERE `order`.`id` = :id AND `order`.`shop_id` = `shop`.`id` AND `order`.`user_place_id` = `user_place`.`id` AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id` ORDER BY `order_time` DESC';
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

	public static function get_ticket_order_meal($ticket) {
		$sql = 'SELECT `order_meal`.`id` AS `meal_id`, `meal`.`name`, `meal`.`price`, `order_meal`.`quantity`, `order_meal`.`note` FROM `order_meal`, `meal` WHERE `order_meal`.`meal_id` = `meal`.`id` AND `order_meal`.`order_id` = :order';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':order', $ticket, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_user_ticket_count($user) {
		$ticket_status = implode(",", TICKET_STATUS_ACTIVE);
		$sql = 'SELECT COUNT(*) FROM `user_order` WHERE `user_id` = :user AND `status` IN (' . $ticket_status . ')';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':user', $user, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}
}