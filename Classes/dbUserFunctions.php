<?php

//todo mysqli_real_escape_string
class dbUserFunctions {

	private $db;
    function __construct() {
		require_once("db.php");	
		require_once("dbBasicFunctions.php");
		$this->db = new database();
		$this->dbBasicFunctions = new dbBasicFunctions();
    }
	
    // destructor
    function __destruct() {
        mysqli_close($this->db->getLink());
    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($table, $name, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
		
		$existing = $this->dbBasicFunctions->dbSelect("SELECT * from ".$this->dbBasicFunctions->escape_string($table)." WHERE email='".$this->dbBasicFunctions->escape_string($email)."'");
		if(is_array($existing) && isset($existing[0])){
			$result = $this->dbBasicFunctions->dbUpdateArray($table,$existing[0]['id'], array("name" => $name, "encrypted_password" => $encrypted_password, "salt" => $salt, "updated_at" => date('Y-m-d G:i:s')));
			if($result == true){
				response("dbUserFunctions->storeUser", 1, 0, true);
				return true;
			} else {
				response("dbUserFunctions->storeUser", 0, 1, $result);
				return false;
			}
		}
		else {
			$userArray = array("unique_id" => $uuid, "name" => $name, "email" => $email, "encrypted_password" => $encrypted_password, "salt" => $salt, "created_at" => date('Y-m-d G:i:s'));
			//$result = mysqli_query($this->db->getLink(), "INSERT INTO $table(unique_id, name, email, encrypted_password, salt, created_at) VALUES('$uuid', '$name', '$email', '$encrypted_password', '$salt', NOW())");
			$result = $this->dbBasicFunctions->dbInsertArray($table, $userArray);
		}
       
        // check for successful store
        if ($result) {
            // get user details 
            $result = $this->dbBasicFunctions->dbSelect("SELECT * FROM $table WHERE unique_id = \"$uuid\"");
            // return user details
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($table, $email, $password) {
        $result = mysqli_query($this->db->getLink(), "SELECT * FROM $table WHERE email = '$email'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysqli_fetch_assoc($result);

            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkHashSSHA($salt, $password);

            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $result;
            }
			else {
				return "password wrong";
			}
        } else {
            // user not found
            return false;
        }
    }

    /**
     * Check if user exists or not
     */
    public function userExists($table, $email) {
        $result = mysqli_query($this->db->getLink(), "SELECT email from $table WHERE email = '$email'");
        $rows = mysqli_num_rows($result);
        if ($rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = hash('sha256', rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(hash('sha512', $password . $salt) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkHashSSHA($salt, $password) {

        $hash = base64_encode(hash('sha512', $password . $salt) . $salt);
        return $hash;
    }
	
	public function setActive($table, $user_id) {
		$result = mysqli_query($this->db->getLink(), "UPDATE ".WS_CONNECTION_USER_TABLE." SET login_active = NOW() WHERE id='$user_id';");
		return $result;
	}
	
	public function wsIsActive($uniqueID) {
		$uniqueID = mysqli_real_escape_string($this->db->getLink(), $uniqueID);
		$result = mysqli_query($this->db->getLink(), "SELECT login_active from ".WS_CONNECTION_USER_TABLE." WHERE unique_id = '$uniqueID'");
		
		$rows = mysqli_num_rows($result);
		if($rows > 0) {
			$result = mysqli_fetch_array($result);
			if(strtotime('- 15 minutes') > strtotime($result['login_active'])) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
}