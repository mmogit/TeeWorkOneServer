<?php
require_once("Classes/dbUserFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");
/*
return hash out of ws_user

*/
function wsLogin($action, $data) {

	$userFunctions = new dbUserFunctions();
	
	$data = json_decode($data, true);
	if(isset($data['user_email']) && isset($data['user_password'])) {
		if($data['user_email'] != "" && $data['user_password'] != "") {
			$user = $userFunctions->getUserByEmailAndPassword(TW_USER_TABLE, $data['user_email'], $data['user_password']);
		}
		if(is_array($user)) {
			$result = $userFunctions->setActive(TW_USER_TABLE, $user['id']);
			if($result) {
				response($action, 1, 0, $user['unique_id']);
			} else {
				response($action, 0, 1, "cannot set user active");
			}
		} else {
			response($action, 0, 0, "login failed");
		}
	} else {
		response($action, 0, 1, "error in logindata");
	}
	
}