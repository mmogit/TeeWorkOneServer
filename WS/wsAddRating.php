<?php
require_once("Classes/dbBasicFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");


function wsAddRating($action, $data) {

	$dbBasicFunctions = new dbBasicFunctions();
	$data = json_decode($data, true);

	if(isset($data['id_tea']) && isset($data['id_user']) && isset($data['id_rating_unit'])) {
		$existing = $dbBasicFunctions->dbSelect("SELECT * from ".TW_RATINGS_TABLE." WHERE id_user='".$dbBasicFunctions->escape_string($data['id_user'])."' AND id_tea='".$dbBasicFunctions->escape_string($data['id_tea'])."'");
		
		if(is_array($existing) && isset($existing[0])){
			$result = $dbBasicFunctions->dbUpdateArray(TW_RATINGS_TABLE,$existing[0]['id'], array("id_tea" => $data['id_tea'], "id_rating_unit" => $data['id_rating_unit'], "taste" => $data['taste'], "smell" => $data['smell'], "updated_at" => date('Y-m-d G:i:s')));
			if($result == true){
				response($action, 1, 0, true);
				return true;
			} else {
				response($action, 0, 1, $result);
				return false;
			}
		} else {
			$result = $dbBasicFunctions->dbInsertArray(TW_RATINGS_TABLE, array("id_tea" => $data['id_tea'], "id_user" => $data['id_user'], "id_rating_unit" => $data['id_rating_unit'], "taste" => $data['taste'],"smell" => $data['smell'],"created_at" => date('Y-m-d G:i:s')));
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
		response($action, 0, 1, "missing id_tea, id_user or id_rating_unit!");
		return false;
	}
	
}