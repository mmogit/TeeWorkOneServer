<?php
require_once("Classes/dbBasicFunctions.php");
require_once("WS/response.php");
require_once("Settings/default.php");


function wsGetTeas($action, $data) {
	$data = json_decode($data, true);
	$dbBasicFunctions = new dbBasicFunctions();
	$result = json_encode($dbBasicFunctions->dbSelect("SELECT * FROM ".TW_TEA_TABLE));
    if($result)
        response($action, 1, 0, $result);
    else 
        response($action, 0, 0);
}