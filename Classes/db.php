<?PHP

class database{
    protected $databaseLink;
    function __construct(){
        require dirname(__FILE__)."/../Settings/dbSettings.php"; 		
        $this->host = $dbInfo['host'];
        $this->mysql_user = $dbInfo['user'];
        $this->mysql_pass = $dbInfo['pass'];
		$this->database = $dbInfo['database'];
        $this->openConnection();
		if($this->selectDatabase()){
			return $this->getLink();
		} else {
			return false;
		}
    }
    protected function openConnection(){
		$this->databaseLink = mysqli_connect($this->host, $this->mysql_user, $this->mysql_pass);
		if (mysqli_connect_errno()){
			die ("Failed to connect to MySQL: " . mysqli_connect_error());
		}
    }
	protected function selectDatabase() {
		if(mysqli_select_db($this->getLink(), $this->database)) {
			return true;
		} else {
			die("cannot select database ".$this->database);
			return false;
		}		
	}
    function getLink(){
		return $this->databaseLink;
    }
	
}

?>