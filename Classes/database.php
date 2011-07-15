<?php

class SH_Database{
	private static $instance;
	protected $result;
	protected $connection;
	
	private function __construct(){
		$this->connection = mysql_connect("localhost","","");
		mysql_select_db("test_project");	//DEFAULT database = test_project
	}
	
	public static function singleton(){
		if(!isset(self::$instance)){
			self::$instance = new SH_Database();
		}
		
		return self::$instance;	
	}
	
	 // Prevent users to clone the instance
    public function __clone(){
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }		
	
	function __destruct(){
		mysql_close($this->connection);
	}
	
	function doQuery($query){
		$this->result = mysql_query($query,$this->connection);
		if(!$this->result)echo "<pre>".mysql_error()."\n$query</pre>";
	}
	
	function resultArray($type = MYSQL_BOTH){
		$return = array();
		while($row = mysql_fetch_array($this->result,$type)){
			$r = array();
			foreach($row as $key=>$field){
				$r[$key] = htmlentities($field);
			}			
			$return[]=$r;
		}
		return $return;
	}
	
	
}

class SH_CRUD{
	//basic class to provide CRUD functions to models
	
	protected $db;
	protected $table;
	
	function __construct($tbl){
		$this->db = SH_Database::singleton();
		$this->table = $tbl;
	}
	
	function create($record){
		//parse out input from array to string
		$cols = "";
		$vals = "";
		
		foreach($record as $key=>$value){
			$k = mysql_real_escape_string($key);
			$v = mysql_real_escape_string($value);
			
			$cols .= "$k,";
			$vals .= "'$v',";
		}
		
		$cols = substr($cols,0,-1);				
		$vals = substr($vals,0,-1);		

		
		//insert a new record
		$s = sprintf("INSERT INTO %s (%s) VALUES (%s)",$this->table,$cols,$vals);
		$this->db->doQuery($s);	
	}
	
	function read($input=NULL){
		if($input === NULL){
			//didn't specify anything, so give them everything!
			$s = sprintf("SELECT * FROM %s",$this->table);
		}elseif(is_array($input)){
			//they want an array of columns			
		}elseif(is_numeric($input)){
			//they want a number, give them the id.
			$s = sprintf("SELECT * FROM %s WHERE id = '%s'",$this->table,$input);
		}else{
			//i dunno...
		}
	
		$this->db->doQuery($s);
		return $this->db->resultArray();
	
	}
	
	function update($input){
		//parse out input from array to string
			$cols = "";
			$id = NULL;
			
			foreach($input as $key=>$value){
				if($key == 'id'){
					$id = $value;
				}else{
					$k = mysql_real_escape_string($key);
					$v = mysql_real_escape_string($value);				
					$cols .= "$k = '$v', ";
				}
			}
			
			$cols = substr($cols,0,-2);			
			
			//insert a new record
			$s = sprintf("UPDATE %s SET %s WHERE id = '%s'",$this->table,$cols,$id);
			$this->db->doQuery($s);
	
	}
	
	function delete($id){
		$s = sprintf("DELETE FROM %s WHERE id = '%s'",$this->table,$id);
		$this->db->doQuery($s);	
	}
	
	function query($q){
		$this->db->doQuery($q);
		return $this->db->resultArray();
	}

}

class Bookmark extends SH_CRUD{

	function __construct(){
		parent::__construct('bookmarks');
	}
	
	function add($name,$url){
		//add a bookmark
		$this->create(array(	'name'	=>$name,
								'url'	=>strpos($url,'http://') === 0 ? $url : 'http://'.$url
		));
	
	}


}


