<?php
ini_set("display_errors", 1);
require_once("Settings/default.php");
require_once("Classes/dbBasicFunctions.php");
require_once("Classes/dbUserFunctions.php");

class setup {
protected $dbBasicFnc;
protected $dbUserFnc;
	function __construct() {
		$this->dbBasicFnc = new dbBasicFunctions();
		$this->dbUserFnc = new dbUserFunctions();
		$this->createWSUserTable();
		$this->createTWUserTable();
		$this->createTWTeaTable();
		$this->createTWRatingsTable();
		$this->createTWRatingUnitsTable();
	}
	
	function createWSUserTable() {
		
		/*
		Create the webservice user table and add the default user
		*/
		$tblWSUserColumns = array( 
			"id" => "int(11) NOT NULL AUTO_INCREMENT",
			"unique_id" => "varchar(64) CHARACTER SET utf8 NOT NULL",
			"name" => "varchar(50) CHARACTER SET utf8 NOT NULL",
			"email" => "varchar(100) CHARACTER SET utf8 NOT NULL",
			"encrypted_password" => "varchar(64) CHARACTER SET utf8 NOT NULL",
			"salt" => "varchar(16) CHARACTER SET utf8 NOT NULL",
			"created_at" => "datetime NOT NULL",
			"updated_at" => "datetime DEFAULT NULL",
			"login_active" => "datetime DEFAULT NULL",
			"" => "PRIMARY KEY (`id`)",
			"" => "UNIQUE KEY `id` (`id`)"
		);
		
		$this->dbBasicFnc->dbCreateTable(WS_CONNECTION_USER_TABLE, $tblWSUserColumns);
		if(!$this->dbUserFnc->userExists(WS_CONNECTION_USER_TABLE, WS_CONNECTION_EMAIL)) {
			$this->dbUserFnc->storeUser(WS_CONNECTION_USER_TABLE, WS_CONNECTION_USER, WS_CONNECTION_EMAIL, WS_CONNECTION_PASSWORD);		
		}
	}
	
	function createTWTeaTable() {
		/*
		Create the webservice user table and add the default user
		*/
		$tblTWTeaColumns = array( 
			"id" => "int(11) NOT NULL AUTO_INCREMENT",
			"brand" => "varchar(64) CHARACTER SET utf8 NOT NULL",
			"name" => "varchar(64) CHARACTER SET utf8 NOT NULL",
			"steeping_time" => "varchar(64) CHARACTER SET utf8",
			"image" => "varchar(128) CHARACTER SET utf8",
			"created_at" => "datetime NOT NULL",
			"updated_at" => "datetime DEFAULT NULL",
			"" => "PRIMARY KEY (`id`)",
			"" => "UNIQUE KEY `id` (`id`)"
		);
		
		$this->dbBasicFnc->dbCreateTable(TW_TEA_TABLE, $tblTWTeaColumns);
	}
	
	function createTWUserTable() {
		
		/*
		Create the webservice user table and add the default user
		*/
		$tblTWUserColumns = array( 
			"id" => "int(11) NOT NULL AUTO_INCREMENT",
			"unique_id" => "varchar(64) CHARACTER SET utf8 NOT NULL",
			"name" => "varchar(50) CHARACTER SET utf8 NOT NULL",
			//"email" => "varchar(100) CHARACTER SET utf8 NOT NULL",
			"encrypted_password" => "varchar(64) CHARACTER SET utf8 NOT NULL",
			"salt" => "varchar(16) CHARACTER SET utf8 NOT NULL",
			"created_at" => "datetime NOT NULL",
			"updated_at" => "datetime DEFAULT NULL",
			//"login_active" => "datetime DEFAULT NULL",
			"" => "PRIMARY KEY (`id`)",
			"" => "UNIQUE KEY `id` (`id`)"
		);
		
		$this->dbBasicFnc->dbCreateTable(TW_USER_TABLE, $tblTWUserColumns);
	}
	
	function createTWRatingsTable() {
		/*
		Create the webservice user table and add the default user
		*/
		$tblTWRatingsColumns = array( 
			"id" => "int(11) NOT NULL AUTO_INCREMENT",
			"id_tea" => "int(12) NOT NULL",
			"id_user" => "int(12) NOT NULL",
			"taste" => "varchar(64) CHARACTER SET utf8",
			"smell" => "varchar(128) CHARACTER SET utf8",
			"id_rating_unit" => "int(12) NOT NULL",
			"created_at" => "datetime NOT NULL",
			"updated_at" => "datetime DEFAULT NULL",
			"" => "PRIMARY KEY (`id`)",
			"" => "UNIQUE KEY `id` (`id`)"
		);
		
		$this->dbBasicFnc->dbCreateTable(TW_RATINGS_TABLE, $tblTWRatingsColumns);
	}
	
	function createTWRatingUnitsTable() {
		/*
		Create the webservice user table and add the default user
		*/
		$tblTWRatingUnitsColumns = array( 
			"id" => "int(11) NOT NULL AUTO_INCREMENT",
			"title" => "varchar(64) CHARACTER SET utf8 NOT NULL",
			"created_at" => "datetime NOT NULL",
			"updated_at" => "datetime DEFAULT NULL",
			"" => "PRIMARY KEY (`id`)",
			"" => "UNIQUE KEY `id` (`id`)"
		);
		
		$this->dbBasicFnc->dbCreateTable(TW_RATING_UNITS_TABLE, $tblTWRatingUnitsColumns);
	}
}


$setup = new setup();
