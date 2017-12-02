<?php
require_once("Classes/dbUserFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");
/*
return hash out of ws_user and

*/
function wsAddUser($action, $data) {

	$userFunctions = new dbUserFunctions();
	$data = json_decode($data, true);

	if(isset($data['register_username']) && isset($data['register_email']) && isset($data['register_password'])) {
		if(strlen($data['register_username']) <= 1) {
			response($action, 0, 1, "Username too short!");
			return false;
		} else if(!filter_var($data['register_email'], FILTER_VALIDATE_EMAIL)){
			response($action, 0, 1, "Email not valid!");
			return false;
		} else if(strlen($data['register_password']) < 6){
			response($action, 0, 1, "Password too short! (minlen 6)");
			return false;
		} else {
			$result = $userFunctions->storeUser(TW_USER_TABLE, $data['register_username'], $data['register_email'], $data['register_password']);		
			if(is_array($result)){
				response($action, 1, 0, $result['unique_id']);
				return true;
			} else {
				response($action, 0, 1, $result);
				return false;
			}
		}
		
	} else {
		response($action, 0, 1, "missing userdata!");
		return false;
	}
	
}