<?php
require_once("Classes/dbUserFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");
/*
return hash out of ws_user and

*/
function wsAddUser($tag, $data) {

	$userFunctions = new dbUserFunctions();
	$data = json_decode($data, true);
	if(isset($data['register_username']) && isset($data['register_email']) && isset($data['register_password'])) {
		if(strlen($data['register_username']) <= 1) {
			response($tag, 0, 1, "Username too short!");
		} else if(!filter_var($data['register_email'], FILTER_VALIDATE_EMAIL)){
			response($tag, 0, 1, "Email not valid!");
		} else if(strlen($data['register_password']) < 6){
			response($tag, 0, 1, "Password too short! (minlen 6)");
		} else {
			$result = $userFunctions->storeUser(TW_USER_TABLE, $data['register_username'], $data['register_email'], $data['register_password']);		
			if(is_array($result)){
				response($tag, 1, 0, $result['unique_id']);
			} else {
				response($tag, 0, 1, $result);
			}
		}
		
	} else {
		response($tag, 0, 1, "missing userdata!");
	}
	
}