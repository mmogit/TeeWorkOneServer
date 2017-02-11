<?php
require_once("Classes/dbUserFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");
/*
return hash out of ws_user and

*/
function wsLogin($tag, $data) {
	$userFunctions = new dbUserFunctions();
	
	$data = json_decode($data, true);
	$user = $userFunctions->getUserByEmailAndPassword(TW_USER_TABLE, $data['email'], $data['password']);
	if(is_array($user)){
		$result = $userFunctions->setActive(TW_USER_TABLE, $user['id']);
		if($result) {
			response($tag, 1, 0, $user['unique_id']);
		} else {
			response($tag, 0, 1, "cannot set user active");
		}
	} else {
		response($tag, 0, 0, "login failed");
	}
}