<?php

namespace database;

use PDO;
use PDOException;

class connect {
	public static function connect(): PDO {
		$db = require_once FOLDER_PATH . 'config/database.php';
		$db_name = $db['name'];
		$db_username = $db['username'];
		$db_password = $db['password'];
		$db_host = $db['host'];
		$db_post = $db['port'];
		$db_charset = $db['charset'];
		$dsn = 'mysql:dbname=' . $db_name . ';host=' . $db_host . ';port=' . $db_post . ';charset=' . $db_charset;

		try {
			$connect = new PDO($dsn, $db_username, $db_password);
			$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $connect;
		} catch (PDOException $exception) {
			die('DB Connect Error: ' . $exception);
		}
	}
}