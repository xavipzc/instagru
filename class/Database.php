<?php 

	class Database {

		private $conn;

		public function __construct($DB_DSN, $DB_NAME, $DB_USER, $DB_PASSWORD){

			try {
				$this->conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e) {
				echo "<br>Error connecting to mysql: " . $e->getMessage();
			}

		}

		public function query($query, $params = false) {
			
			if ($params){
				$req = $this->conn->prepare($query);
				$req->execute($params);
			}
			else {
				$req = $this->conn->query($query);
			}
			return ($req);
			
		}

	}

?>