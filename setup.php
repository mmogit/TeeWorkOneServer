<?php
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
	
	function createTWUserTable() {
		/*
		Create the webservice user table and add the default user
		*/
		$tblTWUserColumns = array( 
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
		
		$this->dbBasicFnc->dbCreateTable(TW_USER_TABLE, $tblTWUserColumns);
	}
}


$setup = new setup();

$data = array(
'id' => '', 
'test1'=> 123,
'test2'=> 'data2',
'huhu' => "wut"
);
$columns = array(
'id' => 'INT NOT NULL AUTO_INCREMENT',
'test1' => 'INT NOT NULL',
'test2' => 'VARCHAR(20) NOT NULL',
'' => 'PRIMARY KEY (`id`)',
);
//createTable("test", $columns);
//insertArr("test", $data);