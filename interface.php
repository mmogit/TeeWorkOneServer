<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');  
//header('content-type: application/json; charset=utf-8');

ini_set('error_reporting', E_ALL|E_STRICT);
ini_set('display_errors', 1);
require("Settings/default.php"); 
require("Classes/db.php");
require("Classes/dbBasicFunctions.php");
require("Classes/dbUserFunctions.php");
require_once("WS/response.php");
//require("setup.php");

//$setup = new setup();

function checkWSLogin($action, $unique_id) {
	$userFunctions = new dbUserFunctions();

	if(isset($unique_id)) {
		if($userFunctions->wsIsActive($unique_id)) {
			return true;
		} else {
			response($action, 0, 1, "Webservice connection not active - please login!");
		}
	} else {
		response($action, 0, 1, "missing unique_id of connection!");
	}
	return false;
}

 /**
 * check for POST request
 */
if (isset($_REQUEST['action']) && $_REQUEST['action'] != '') {
	// get action
	$action = $_REQUEST['action'];
	if(isset($_REQUEST['unique_id'])) {
		$unique_id = $_REQUEST['unique_id'];
	}
	$data = $_REQUEST['data'];
	
	// check for action type
	switch($action) {
		case "connect": 
			require "WS/connect.php";
			$connection = wsConnect($action, $data);
		break;
		case "checkConnection": 
			require "WS/connect.php";
			checkConnection($action, $data);
		break;
		case "login": 
			if(checkWSLogin($action,$unique_id)) {
				require "WS/login.php";
				wsLogin($action, $data);
			}
		break;
		case "addUser": 
			if(checkWSLogin($action,$unique_id)) {
				die("huhasdf");
				require "WS/addUser.php";
				wsAddUser($action, $data);
			}
		break;
		default:
			echo "{invalid Request}";
		break;
		
	}
} else {
	echo "{Access Denied}";
}
