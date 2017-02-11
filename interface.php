<?php
ini_set('error_reporting', E_ALL|E_STRICT);
ini_set('display_errors', 1);
require("Settings/default.php"); 
require("Classes/db.php");
require("Classes/dbBasicFunctions.php");
require("Classes/dbUserFunctions.php");
require_once("WS/response.php");
//require("setup.php");

//$setup = new setup();

function checkLogin($tag, $data) {
	$userFunctions = new dbUserFunctions();
	$data = json_decode($data, true);
	if(isset($data['ws_unique_id'])) {
		if($userFunctions->wsIsActive($data['ws_unique_id'])) {
			return true;
		} else {
			response($tag, 0, 1, "Webservice connection not active - please login!");
		}
	} else {
		response($tag, 0, 1, "missing unique_id of connection!");
	}
	return false;
}

 /**
 * check for POST request
 */
if (isset($_REQUEST['tag']) && $_REQUEST['tag'] != '') {
	// get tag
	$tag = $_REQUEST['tag'];
	$data = $_REQUEST['data'];
	
	// check for tag type
	switch($tag) {
		case "connect": 
			require "WS/connect.php";
			$connection = wsConnect($tag, $data);
		break;
		case "login": 
			if(checkLogin($tag,$data)) {
				require "WS/login.php";
				wsLogin($tag, $data);
			}
		break;
		case "addUser": 
			if(checkLogin($tag,$data)) {
				require "WS/addUser.php";
				wsAddUser($tag, $data);
			}
		break;
		default:
			echo "{invalid Request}";
		break;
		
	}
} else {
	echo "{Access Denied}";
}
