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
	if(!isset($data['user']) || !isset($data['email']) || !isset($data['password'])) {
		response($tag, 0, 1, "missing credentials! User is: ".$data['user'].", Email is: ".$data['email']);
	} else {
		$result = $userFunctions->storeUser(TW_USER_TABLE, $data['user'], $data['email'], $data['password']);		
		if(is_array($result)){
			response($tag, 1, 0, $result['unique_id']);
		} else {
			response($tag, 0, 1, $result);
		}
	}
	
}