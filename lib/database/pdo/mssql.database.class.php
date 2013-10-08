<?php
/* lib/database/pdo/mssql.database.class.php - DNS-WI
 * Copyright (C) 2013  OWNDNS project
 * http://owndns.me/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License 
 * along with this program. If not, see <http://www.gnu.org/licenses/>. 
 */
if (!extension_loaded("pdo")) die("Missing <a href=\"http://www.php.net/manual/en/book.pdo.php\">PDO</a> PHP extension."); // check if extension loaded
class DB extends database {
	private static $conn = NULL;
	private static $err = NULL;

	/**
	 * @see	database::connect();
	 */
	public static function connect($host, $user, $pw, $db, $driver = "dblib") {
		try {
			if($driver == "dblib") {
				if (!extension_loaded("pdo_dblib")) die("Missing <a href=\"http://php.net/manual/de/ref.pdo-dblib.php\">pdo_dblib</a> PHP extension."); // check if extension
				self::$conn = new PDO("dblib:host=".$host.";dbname=".$db, $user, $pw);
			} elseif($driver == "odbc") {
				if (!extension_loaded("pdo_odbc")) die("Missing <a href=\"http://php.net/manual/de/ref.pdo-odbc.php\">pdo_odbc</a> PHP extension."); // check if extension loaded
				self::$conn = new PDO("odbc:Driver=SQL Server; TDS_Version=8.2; Port=1433; Server=".$host."; Database=".$db."; UID=".$user."; PWD=".$pw.";");
			} else {
				die("not supported driver");
			}
			return true;
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
			return false;
		}
	}
	
	/**
	 * @see	database::close();
	 */
	public static function close () {
		self::$conn = NULL;
	}
	
	/**
	 * @see	database::query();
	 */
	public static function query ($res, $bind = array()) {
		try {
			$query = self::$conn->prepare($res);
			if(is_array($bind) && !empty($bind))
				$query->execute($bind);
			else
				$query->execute();
			return $query;
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
		}
	}

	
	/**
	 * @see	database::fetch_array();
	 */
	public static function fetch_array ($res) {
		try {
			return $res->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
		}
	}
	
	/**
	 * @see	database::num_rows();
	 */
	public static function num_rows ($res) {
		try {
			return $res->rowCount();
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
		}
	}
	
	/**
	 * @see	database::error();
	 */
	public static function error () {
		return self::$err;
	}
}
?>
