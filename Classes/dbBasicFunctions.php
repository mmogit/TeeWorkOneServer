<?php
require_once("Classes/db.php");

class dbBasicFunctions {
	function dbInsertArray($tableName, $insData){
		$db = new database();
		
		$columns = implode(", ",array_keys($insData));
		$escaped_values = array_map(array($this, 'escape_string'), array_values($insData));
		foreach ($escaped_values as $idx=>$data) $escaped_values[$idx] = "'".$data."'";
		$values  = implode(", ", $escaped_values);
		$query = "INSERT INTO $tableName ($columns) VALUES ($values)";
		
		mysqli_query($db->getLink(), $query) or die(mysqli_error($db->getLink()));
		mysqli_close($db->getLink());
	}

	function dbCreateTable($tableName, $columns) {
		$db = new database();
		$escaped_columns = array_map(array($this, 'escape_string'), array_keys($columns));
		$columnsWithTypes = array_map(array($this, 'addTypesToColumns'), $escaped_columns, array_values($columns));
		$columnsString = implode(", ", $columnsWithTypes);
		$createTable = "CREATE TABLE IF NOT EXISTS $tableName ($columnsString);";
		mysqli_query($db->getLink(), $createTable) or die(mysqli_error($db->getLink()));
		mysqli_close($db->getLink());
	}
	function addTypesToColumns($column, $type) {
		if($column != '') {
		$columnsWithTypes = "`$column` $type";
		} else {
			$columnsWithTypes = "$type";
		}
		return $columnsWithTypes;
	}
	function escape_string($data) {
		$db = new database();
		return mysqli_real_escape_string($db->getLink(), $data);
		mysqli_close($db->getLink());
	}
}