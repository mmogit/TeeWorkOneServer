<?php
require_once("Classes/dbBasicFunctions.php");
require_once("Classes/dbUserFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");


function wsGetUser($action, $data) {
	$data = json_decode($data, true);
	$dbUserFunctions = new dbUserFunctions();
	$result = json_encode($dbUserFunctions->getUserByEmailAndPassword(TW_USER_TABLE, $data['email'], $data['password']));
    if($result)
        response($action, 1, 0, $result);
    else 
        response($action, 0, 0);
}