<?php
require_once("Classes/dbBasicFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");
/*
return hash out of ws_user and

*/
function wsGetRatings($action, $data) {

	$dbTWFunctions = new dbTWFunctions();
	$result = json_encode($dbTWFunctions->dbGetRatings());
	response($action, 0, 0, $result);
}