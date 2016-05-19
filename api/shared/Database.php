<?php
/**
 * DB Connection Manager
 *
 * @author Agostino G. Manzi
 */

namespace MyBoard\Api\Shared{
require_once 'Conf.php';
use Exception;
use PDO;

	 class Database{

		private static $connection = null;
		private static $dbInstance = null;

		private function __construct() {

		}

		const FETCH_CLASS = PDO::FETCH_CLASS;

		public static function getConnection(){

			if(self::$connection === null){

				$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
				$connString = "mysql:host=" . DB_SERVER . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
				try {
					self::$connection = new PDO($connString, DB_USR, DB_PWD, $options);
					self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					self::$connection->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

				} catch(Exception $e) {
					//gestire eccezione qui
					echo $e;
				}
			}
			return self::$connection;
		}

		/**
		 * Get a singleton instance of DB Manager
		 *
		 * @return Database DB Manager Instance
		 */
		public static function getInstance(){
			if(self::$connection === null){
				self::$dbInstance = new Database();
			}
			return self::$dbInstance;
		}

		/**
		 * Dispose Object
		 *
		 * @access public
		 * @return void
		 */
		public function __destruct() {
			//Aggiungere eventuale codice per Dispose

		}

	 }

 }
?>