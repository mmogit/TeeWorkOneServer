<?php
//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Methods: GET, POST');
//header('content-type: application/json; charset=utf-8');
ini_set('error_reporting', E_ALL|E_STRICT);
ini_set('display_errors', 1);
require("Settings/default.php"); 
require("Classes/db.php");
require("Classes/dbBasicFunctions.php");
require("Classes/dbUserFunctions.php");
require_once("WS/response.php");

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
		case "addUser": 
			require "WS/wsAddUser.php";
            wsAddUser($action, $data);
		break;
		case "addRatingUnit": 
            require "WS/wsAddRatingUnit.php";
			wsAddRatingUnit($action, $data);
		break;
		case "addTea": 
            require "WS/wsAddTea.php";
			wsAddTea($action, $data);
		break;
		case "addRating": 
            require "WS/wsAddRating.php";
			wsAddRating($action, $data);
		break;
		case "getRatings": 
            require "WS/wsGetRatings.php";
			wsGetRatings($action, $data);
		break;
		case "getRatingUnits": 
            require "WS/wsGetRatingUnits.php";
			wsGetRatingUnits($action, $data);
		break;
		case "getTeas": 
            require "WS/wsGetTeas.php";
			wsGetTeas($action, $data);
		break;
		case "getUser": 
            require "WS/wsGetUser.php";
			wsGetUser($action, $data);
		break;
		case "getUserByID": 
            require "WS/wsGetUserByID.php";
			wsGetUserByID($action, $data);
		break;
		case "getRatingUnitByID": 
            require "WS/wsGetRatingUnitByID.php";
			wsGetRatingUnitByID($action, $data);
		break;
		case "getTeaByID": 
            require "WS/wsGetTeaByID.php";
			wsGetTeaByID($action, $data);
		break;
		default:
			echo "{invalid Request}";
		break;
		
	}
} else {
	echo "{Access Denied}";
}
