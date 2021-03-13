<?php



function pdo_dbconn() {
	try {
		$DBHOST="localhost";
		$DBNAME="digitized";
		$DBUSER="root";
		$DBPASS="";

		$pdo = new PDO("mysql:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS);
		
		return $pdo;
	}
	catch (PDOException $e) {
		
		die ($e->getMessage());
	}
}