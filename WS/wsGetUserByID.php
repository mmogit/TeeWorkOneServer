<?php
require_once("Classes/dbBasicFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");


function wsGetUserByID($action, $data) {
	$data = json_decode($data, true);
	$dbBasicFunctions = new dbBasicFunctions();
	$result = json_encode($dbBasicFunctions->dbSelect("SELECT id, unique_id, name, email FROM ".TW_USER_TABLE" where id='".$dbBasicFunctions->escape_string($data['id'])."'"));
    if($result)
        response($action, 1, 0, $result);
    else 
        response($action, 0, 0);
}