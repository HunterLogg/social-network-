<?php
class DBController {
	private $host = "127.0.0.1";
	private $user = "root";
	private $password = "";
	private $database = "fb";
	
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB(); 
		if(!empty($this->conn)) {
		    $this->selectDB();
		}
	}

	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function selectDB() {
	    mysqli_select_db($this->conn, $this->database);
	}
	
	function runQuery($query) {
	    $result = mysqli_query($this->conn, $query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		//print_r($resultset);
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
	    $result  = mysqli_query($this->conn, $query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;
	}
	
	function insert($query) {
	    $insert_id = "";
	    $result  = mysqli_query($this->conn, $query);
	    if(!empty($result)) {
	        $insert_id = mysqli_insert_id($this->conn);
	    }
	    return $insert_id;
	}

	function update($query){
		$result = mysqli_query($this->conn,$query);
	}
	
	function execute($query) {
	    $result  = mysqli_query($this->conn, $query);
	    return $result;
	}



}

//  $db_handle = new DBController(); 
// 	$query = "SELECT * FROM messages  ";
//  $result = $db_handle->numRows($query);
//  echo $result;
 //$posts = $db_handle->runQuery("SELECT * FROM posts WHERE user_id = '10'");
?>
