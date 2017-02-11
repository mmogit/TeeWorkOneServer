<?php
//todo mysqli_real_escape_string
class dbUserFunctions {

	private $db;
    function __construct() {
		require_once("db.php");	
		$this->db = new database();
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
		$result = mysqli_query($this->db->getLink(), "INSERT INTO $table(unique_id, name, email, encrypted_password, salt, created_at) VALUES('$uuid', '$name', '$email', '$encrypted_password', '$salt', NOW())");
        // check for successful store
        if ($result) {
            // get user details 
            $result = mysqli_query($this->db->getLink(), "SELECT * FROM $table WHERE unique_id = \"$uuid\"");
            // return user details
            return mysqli_fetch_array($result);
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
            $result = mysqli_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $result;
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

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
	
	public function setActive($table, $user_id) {
		$result = mysqli_query($this->db->getLink(), "UPDATE ".WS_CONNECTION_USER_TABLE." SET login_active = NOW() WHERE id='$user_id';");
		return $result;
	}
	
	public function wsIsActive($uniqueID) {
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