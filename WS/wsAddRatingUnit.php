<?php
require_once("Classes/dbBasicFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");
/*
return hash out of ws_user and

*/
function wsAddRatingUnit($action, $data) {

	$dbBasicFunctions = new dbBasicFunctions();
	$data = json_decode($data, true);

	if(isset($data['title'])) {
		$existing = $dbBasicFunctions->dbSelect("SELECT * from ".TW_RATING_UNITS_TABLE." WHERE title='".$dbBasicFunctions->escape_string($data['title'])."'");
		if(is_array($existing) && isset($existing[0])){
			$result = $dbBasicFunctions->dbUpdateArray(TW_RATING_UNITS_TABLE,$existing[0]['id'], array("title" => $data['title'], "updated_at" => date('Y-m-d G:i:s')));
			if($result == true){
				response($action, 1, 0, true);
				return true;
			} else {
				response($action, 0, 1, $result);
				return false;
			}
		}
		else {
			$result = $dbBasicFunctions->dbInsertArray(TW_RATING_UNITS_TABLE, array("title" => $data['title'], "created_at" => date('Y-m-d G:i:s')));
			if($result == true){
				response($action, 1, 0, true);
				return true;
			} else {
				response($action, 0, 1, $result);
				return false;
			}
		}
	}	
	 else {
		response($action, 0, 1, "missing rating unit title!");
		return false;
	}
	
}