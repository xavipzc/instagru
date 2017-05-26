<?php 

	class App {

		static $db = null;

		static function getDatabase(){
			if (!self::$db) {
				require ('config/database.php');
				self::$db = new Database($DB_DSN, $DB_NAME, $DB_USER, $DB_PASSWORD);
			}
			return (self::$db);
		}
	}

?>