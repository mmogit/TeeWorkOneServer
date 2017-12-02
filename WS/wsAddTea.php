<?php
require_once("Classes/dbBasicFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");


function wsAddTea($action, $data) {

	$dbBasicFunctions = new dbBasicFunctions();
	$data = json_decode($data, true);

	if(isset($data['brand']) && isset($data['name'])) {
		$existing = $dbBasicFunctions->dbSelect("SELECT * from ".TW_TEA_TABLE." WHERE brand='".$dbBasicFunctions->escape_string($data['brand'])."' AND name='".$dbBasicFunctions->escape_string($data['name'])."'");
		if(is_array($existing) && isset($existing[0])){
			$result = $dbBasicFunctions->dbUpdateArray(TW_TEA_TABLE,$existing[0]['id'], array("brand" => $data['brand'], "name" => $data['name'], "steeping_time" => $data['steeping_time'],  "updated_at" => date('Y-m-d G:i:s')));
			if($result == true){
				response($action, 1, 0, true);
				return true;
			} else {
				response($action, 0, 1, $result);
				return false;
			}
		}
		else {
			$result = $dbBasicFunctions->dbInsertArray(TW_TEA_TABLE, array("brand" => $data['brand'], "name" => $data['name'], "steeping_time" => $data['steeping_time'], "created_at" => date('Y-m-d G:i:s')));
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