<?php

namespace database;

use PDO;
use PDOException;

require_once FOLDER_PATH . 'database/connect.php';

class tickets {
	public static function get_delivery_all_tickets($delivery) {
		$sql = 'SELECT `order`.`id` AS `order_id`, `order`.`status` AS `order_status`, `order`.`order_time`, `order`.`note` AS `order_note`, `shop`.`id` AS `shop_id`, `shop`.`name` AS `shop_name`, `user`.`name` AS `user_name`, `delivery`.`name` AS `delivery_name`, `order`.`user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM ( `user_order` AS `order` LEFT JOIN `user` AS `delivery` ON `order`.`delivery_id` = `delivery`.`id` ), `shop`, `user_place`, `place_room`, `place_build`, `place_area`, `user` WHERE `order`.`delivery_id` = :delivery AND `order`.`shop_id` = `shop`.`id` AND `order`.`user_place_id` = `user_place`.`id` AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id` AND `order`.`user_id` = `user`.`id` ORDER BY `order_time` DESC';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':delivery', $delivery, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_delivery_single_tickets($id, $delivery) {
		$sql = 'SELECT `order`.`id` AS `order_id`, `order`.`status` AS `order_status`, `order`.`order_time`, `order`.`note` AS `order_note`, `shop`.`id` AS `shop_id`, `shop`.`name` AS `shop_name`, `user`.`name` AS `user_name`, `user`.`phone` AS `user_phone`, `delivery`.`name` AS `delivery_name`, `order`.`user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM ( `user_order` AS `order` LEFT JOIN `user` AS `delivery` ON `order`.`delivery_id` = `delivery`.`id` ), `shop`, `user_place`, `place_room`, `place_build`, `place_area`, `user` WHERE `order`.`delivery_id` = :delivery AND `order`.`id` = :id AND `order`.`shop_id` = `shop`.`id` AND `order`.`user_place_id` = `user_place`.`id` AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id` AND `order`.`user_id` = `user`.`id` ORDER BY `order_time` DESC';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':delivery', $delivery, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function change_delivery_tickets_status($id, $delivery, $status) {
		$sql = 'UPDATE `user_order` SET `status` = :status WHERE `user_order`.`id` = :id AND `delivery_id` = :delivery';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':delivery', $delivery, PDO::PARAM_INT);
			$stmt->bindValue(':status', $status, PDO::PARAM_INT);
			return $stmt->execute();
		} catch (PDOException $exception) {
			die('DB UPDATE Error: ' . $exception);
		}
	}

	public static function change_tickets_delivery($id, $delivery) {
		$sql = 'UPDATE `user_order` SET `delivery_id` = :delivery WHERE `user_order`.`id` = :id';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':delivery', $delivery, PDO::PARAM_INT);
			return $stmt->execute();
		} catch (PDOException $exception) {
			die('DB UPDATE Error: ' . $exception);
		}
	}

	public static function get_all_tickets_need_delivery() {
		$ticket_status = implode(",", TICKET_STATUS_NEED_DELIVERY);
		$sql = 'SELECT `order`.`id` AS `order_id`, `order`.`status` AS `order_status`, `order`.`order_time`, `order`.`note` AS `order_note`, `shop`.`id` AS `shop_id`, `shop`.`name` AS `shop_name`, `user`.`name` AS `user_name`, `delivery`.`name` AS `delivery_name`, `order`.`user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM ( `user_order` AS `order` LEFT JOIN `user` AS `delivery` ON `order`.`delivery_id` = `delivery`.`id` ), `shop`, `user_place`, `place_room`, `place_build`, `place_area`, `user` WHERE `order`.`shop_id` = `shop`.`id` AND `order`.`user_place_id` = `user_place`.`id` AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id` AND `order`.`user_id` = `user`.`id` AND `order`.`delivery_id` IS NULL AND `order`.`status` IN (' . $ticket_status . ') ORDER BY `order_status` DESC, `order_time` ASC';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_single_tickets_need_delivery($id) {
		$ticket_status = implode(",", TICKET_STATUS_NEED_DELIVERY);
		$sql = 'SELECT `order`.`id` AS `order_id`, `order`.`status` AS `order_status`, `order`.`order_time`, `order`.`note` AS `order_note`, `shop`.`id` AS `shop_id`, `shop`.`name` AS `shop_name`, `user`.`name` AS `user_name`, `delivery`.`name` AS `delivery_name`, `order`.`user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM ( `user_order` AS `order` LEFT JOIN `user` AS `delivery` ON `order`.`delivery_id` = `delivery`.`id` ), `shop`, `user_place`, `place_room`, `place_build`, `place_area`, `user` WHERE `order`.`id` = :id AND `order`.`shop_id` = `shop`.`id` AND `order`.`user_place_id` = `user_place`.`id` AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id` AND `order`.`user_id` = `user`.`id` AND `order`.`delivery_id` IS NULL AND `order`.`status` IN (' . $ticket_status . ') ORDER BY `order_status` DESC, `order_time` ASC';
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

	public static function get_my_tickets_count($user) {
		$ticket_status = implode(",", TICKET_STATUS_ACTIVE);
		$sql = 'SELECT COUNT(*) FROM `user_order` WHERE `delivery_id` = :user AND `status` IN (' . $ticket_status . ')';
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

	public static function get_shop_tickets_count($id) {
		$shop = tickets::get_shop_id($id);
		$ticket_status = implode(",", TICKET_STATUS_ACTIVE);
		$sql = 'SELECT COUNT(*) FROM `user_order` WHERE `shop_id` = :shop AND `status` IN (' . $ticket_status . ')';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':shop', $shop, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_shop_id($id) {
		$sql = 'SELECT `id` FROM `shop` WHERE `user_id` = :id';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_shop_all_tickets($id) {
		$ticket_status = implode(",", TICKET_STATUS_SHOP_SHOW);
		$shop = tickets::get_shop_id($id);
		$sql = 'SELECT `order`.`id` AS `order_id`, `order`.`status` AS `order_status`, `order`.`order_time`, `order`.`note` AS `order_note`, `shop`.`id` AS `shop_id`, `shop`.`name` AS `shop_name`, `user`.`name` AS `user_name`, `delivery`.`name` AS `delivery_name`, `order`.`user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM ( `user_order` AS `order` LEFT JOIN `user` AS `delivery` ON `order`.`delivery_id` = `delivery`.`id` ), `shop`, `user_place`, `place_room`, `place_build`, `place_area`, `user` WHERE `order`.`shop_id` = :shop AND `order`.`shop_id` = `shop`.`id` AND `order`.`user_place_id` = `user_place`.`id` AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id` AND `order`.`user_id` = `user`.`id` AND `order`.`status` IN (' . $ticket_status . ') ORDER BY `order_status` ASC, `order_time` DESC';
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

	public static function get_shop_single_tickets($id, $shop) {
		$shop_id = tickets::get_shop_id($shop);
		$sql = 'SELECT `order`.`id` AS `order_id`, `order`.`status` AS `order_status`, `order`.`order_time`, `order`.`note` AS `order_note`, `shop`.`id` AS `shop_id`, `shop`.`name` AS `shop_name`, `user`.`name` AS `user_name`, `user`.`phone` AS `user_phone`, `delivery`.`name` AS `delivery_name`, `delivery`.`phone` AS `delivery_phone`, `order`.`user_place_id`, `user_place`.`name` AS `user_place_name`, `user_place`.`detail` AS `user_place_detail`, `place_room`.`name` AS `room_name`, `place_build`.`name` AS `build_name`, `place_area`.`name` AS `area_name` FROM ( `user_order` AS `order` LEFT JOIN `user` AS `delivery` ON `order`.`delivery_id` = `delivery`.`id` ), `shop`, `user_place`, `place_room`, `place_build`, `place_area`, `user` WHERE `order`.`id` = :id AND `order`.`shop_id` = :shop AND `order`.`shop_id` = `shop`.`id` AND `order`.`user_place_id` = `user_place`.`id` AND `user_place`.`place_id` = `place_room`.`id` AND `place_room`.`build_id` = `place_build`.`id` AND `place_build`.`area_id` = `place_area`.`id` AND `order`.`user_id` = `user`.`id` ORDER BY `order_time` DESC';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':shop', $shop_id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function change_shop_tickets_status($id, $shop, $status) {
		$shop_id = tickets::get_shop_id($shop);
		$sql = 'UPDATE `user_order` SET `status` = :status WHERE `user_order`.`id` = :id AND `shop_id` = :shop';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':shop', $shop_id, PDO::PARAM_INT);
			$stmt->bindValue(':status', $status, PDO::PARAM_INT);
			return $stmt->execute();
		} catch (PDOException $exception) {
			die('DB UPDATE Error: ' . $exception);
		}
	}
}