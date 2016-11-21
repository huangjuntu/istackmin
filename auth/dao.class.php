<?php
require_once('config.db.php');
class DAO
{
	private $mysqli;
	private $result;

	function __construct() 
	{
	    $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
         if ($this->mysqli->connect_errno) {
               echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
         }
         $this->mysqli->query('SET NAMES "utf8"');
	}

	public function __destruct() 
	{
         $this->close_connection();
	}

	public function close_connection()
	{
        /*var_dump($this->mysqli) or var_dump($this->result) always shows null properties, but accessing the properties individually shows they exist*/
        // is_null($this->mysqli->thread_id) or $this->mysqli->close();
        // is_null($this->result) or $this->result->free();
        // Add the above two lines will generate DAO::close_connection(): Couldn't fetch mysqli error in the /var/log/httpd/error.log, seem like php will do gabage collection automatically
	}

	public function query($sql)
	{
         $this->result = $this->mysqli->query($sql);
	    return $this->result;
	}

	public function fetch()
	{ 
          if($this->result){
               if($row = $this->result->fetch_assoc()){
                    return $row;
               }else{
                    $this->result->free();
               }
          }
          return false;
	}

	public function fetch_all()
	{ 
          if($this->result){
               $result = array();
               for($i=0; $row = $this->result->fetch_row(); $i++){
                   $result[$i] = $row;
               }
               $this->result->free();
               return $result;
          }
	     return false;
	}

  public function fetch_all_keys()
  { 
          if($this->result){
               $result = array();
               while ($row = $this->result->fetch_assoc()) {
                array_push($result, $row);
               }
               $this->result->free();
               return $result;
          }
       return false;
  }

  public function get_insert_id(){
    if($this->mysqli){
      return (int)mysqli_insert_id($this->mysqli);
    }
    return 0;
  }
}
?>
