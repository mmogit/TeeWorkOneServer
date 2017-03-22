<?php
require_once("Classes/db.php");
require_once("Settings/default.php");

class dbTWFunctions {
	function dbGetRatings(){
		$db = new database();
		
		$query = "SELECT * from ".TW_RATINGS_TABLE."";
		
		$result = mysqli_query($db->getLink(), $query) or die(mysqli_error($db->getLink()));
		if ($result->num_rows > 0) {
			return mysqli_fetch_all($result);
		}
		mysqli_close($db->getLink());
	}
}