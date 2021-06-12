<?php

namespace database;

use PDO;
use PDOException;

require_once FOLDER_PATH . 'database/connect.php';

class user {
	public static function token_add($id, $token) {
		$sql = 'INSERT INTO `user_token` (`id`, `user_id`, `token`, `enable`, `time`) VALUES (NULL, :user, :token, :enable, current_timestamp())';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':user', $id, PDO::PARAM_INT);
			$stmt->bindValue(':token', $token, PDO::PARAM_STR);
			$stmt->bindValue(':enable', 1, PDO::PARAM_INT);
			$stmt->execute();
			return $conn->lastInsertId();
		} catch (PDOException $exception) {
			die('DB INSERT Error: ' . $exception);
		}
	}

	public static function token_verify($token) {
		$sql = 'SELECT `user`.`id`, `user`.`account`, `user`.`name`, `user`.`email` FROM `user_token`, `user` WHERE `user_token`.`token` = :token AND `user_token`.`user_id` = `user`.`id` AND `user_token`.`enable` = 1 ORDER BY `user_token`.`time` DESC';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':token', $token, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function verify($account, $password) {
		$password = hash('sha256', $password);
		$sql = 'SELECT `id`, `account`, `name`, `type` FROM `user` WHERE `account` = :account AND `password` = :password';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':account', $account, PDO::PARAM_STR);
			$stmt->bindValue(':password', $password, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function add_user($account, $name, $email, $phone, $password, $type): string {
		$password = hash('sha256', $password);
		$sql = 'INSERT INTO `user` (`id`, `account`, `name`, `email`, `phone`, `password`, `type`) VALUES (NULL, :account, :name, :email, :phone, :password, :type)';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':account', $account, PDO::PARAM_STR);
			$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->bindValue(':email', $email, PDO::PARAM_STR);
			$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
			$stmt->bindValue(':password', $password, PDO::PARAM_STR);
			$stmt->bindValue(':type', $type, PDO::PARAM_INT);
			$stmt->execute();
			return $conn->lastInsertId();
		} catch (PDOException $exception) {
			die('DB INSERT Error: ' . $exception);
		}
	}

	public static function account_exist($account): bool {
		$sql = 'SELECT `id` FROM `user` WHERE `account` = :account';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':account', $account, PDO::PARAM_STR);
			$stmt->execute();
			if ($stmt->fetch(PDO::FETCH_ASSOC)) {
				return true;
			} else {
				return false;
			}
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function email_exist($email): bool {
		$sql = 'SELECT `id` FROM `user` WHERE `email` = :email';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':email', $email, PDO::PARAM_STR);
			$stmt->execute();
			if ($stmt->fetch(PDO::FETCH_ASSOC)) {
				return true;
			} else {
				return false;
			}
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}

	public static function get_single($id) {
		$sql = 'SELECT `id`, `account`, `name`, `email`, `phone`, `type` FROM `user` WHERE `id` = :id';
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

	public static function logout_token($token) {
		$sql = 'UPDATE `user_token` SET `enable` = 0 WHERE `user_token`.`token` = :token';
		try {
			$conn = connect::connect();
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			return $stmt->execute();
		} catch (PDOException $exception) {
			die('DB SELECT Error: ' . $exception);
		}
	}
}