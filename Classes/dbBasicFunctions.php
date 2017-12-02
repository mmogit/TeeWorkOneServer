<?php
require_once("Classes/db.php");

class dbBasicFunctions {
    function dbSelect($query){
		$db = new database();		
		$dbresult = mysqli_query($db->getLink(), $query) or die(mysqli_error($db->getLink()));
        $resultarray = array();
        while ($row = mysqli_fetch_assoc($dbresult)) {
            $resultarray[] = $row;
        }
        mysqli_free_result($dbresult);
        mysqli_close($db->getLink());
        
        return $resultarray;
	}
	function dbInsertArray($tableName, $insData){
		$db = new database();
		
		$columns = implode(", ",array_keys($insData));
		$escaped_values = array_map(array($this, 'escape_string'), array_values($insData));
		foreach ($escaped_values as $idx=>$data) $escaped_values[$idx] = "'".$data."'";
		$values  = implode(", ", $escaped_values);
		$query = "INSERT INTO $tableName ($columns) VALUES ($values)";
		
		mysqli_query($db->getLink(), $query) or die(mysqli_error($db->getLink()));
		mysqli_close($db->getLink());
		return true;
	}
	function dbUpdateArray($tableName, $idToUpdate, $insData){
		$db = new database();
		
		$query = "UPDATE $tableName set ";
		foreach($insData as $key => $val) {
			$query .= $this->escape_string($key)."='".$this->escape_string($val)."' ";
			if( next( $insData ) !== FALSE ) {
				$query .= ", ";
			}
		}
		$query .= " WHERE id='".intval($this->escape_string($idToUpdate))."'";
		
		mysqli_query($db->getLink(), $query) or die(mysqli_error($db->getLink()));
		mysqli_close($db->getLink());
		return true;
	}
	function exists($tableName, $column, $value) {
		$db = new database();
		
		$column = $this->escape_string($column);
		$value = $this->escape_string($value);
		
		$dbresult = mysqli_query($db->getLink(), "select * from $tableName where $column='$value'") or die(mysqli_error($db->getLink()));
		$count = mysqli_num_rows($dbresult);
		if($count > 0)
			return true;
		else
			return false;
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