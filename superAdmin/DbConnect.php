<?php 
	class DbConnect {
		private $host = 'localhost';
		private $dbName = 'u357079883_resultgrading1';
		private $user = 'u357079883_danielalala';
		private $pass = 'Thesisismydeath1';

		public function connect() {
			try {
				$conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch( PDOException $e) {
				echo 'Database Error: ' . $e->getMessage();
			}
		}
	}
 ?>