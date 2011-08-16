<?php
class SH_Database{
	private static $instance;
	protected $result;
	protected $connection;
	
	private function __construct(){
		$this->connection = mysql_connect("localhost","server_bot","bot_me");
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
	
	function resultArray($type = MYSQL_ASSOC){
		$return = array();
		if(is_resource($this->result)){
			while($row = mysql_fetch_array($this->result,$type)){
				$r = array();
				foreach($row as $key=>$field){
					$r[$key] = htmlentities($field);
				}			
				$return[]=$r;
			}
		}else $return = $this->result;
		
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
		return mysql_insert_id();
	}
	
	function read($input=NULL){
		if($input === NULL){
			//didn't specify anything, so give them everything!
			$s = sprintf("SELECT * FROM %s",$this->table);
		}elseif(is_array($input)){
			//they want specific columns matched
			$where = '';
			foreach($input as $key=>$value){
				$where .= "$key = '$value' AND ";
			}
			$where = substr($where,0,-5);	//trim off the last "AND" 
			$s = sprintf("SELECT * FROM %s WHERE %s",$this->table,$where);			
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
		if(is_array($id)){
			//they want specific columns matched
			$where = '';
			foreach($id as $key=>$value){
				$where .= "$key = '$value' AND ";
			}
			$where = substr($where,0,-5);	//trim off the last "AND" 
			$s = sprintf("DELETE FROM %s WHERE %s",$this->table,$where);			
		}elseif(is_numeric($input)){
			//just a plain old delete ID
			$s = sprintf("DELETE FROM %s WHERE id = '%s'",$this->table,$input);
		}else{
			//i dunno...
			return false;
		}		
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
		return $this->create(array(	'title'	=>$name,
								'url'	=>strpos($url,'http://') === 0 ? $url : 'http://'.$url
		));
	
	}
	
	function like($id){
		$likes = $this->query("SELECT favourite FROM bookmarks WHERE id = '$id'");
		$newLikes = (int) $likes[0][0] + 1;
		$this->query("UPDATE bookmarks SET favourite = '$newLikes' WHERE id = '$id'");
	}


}

class User extends SH_CRUD{
	//model representing the user table
	
	private $userid;
	
	function __construct($id){
		parent::__construct('users');
		$this->userid = $id;
	}
	
}

class User_Bookmark extends SH_CRUD{
	//model object for user_bookmark table
	private $bookmark;
	private $user;
	private $userid;

	function __construct($id){
		parent::__construct('user_bookmarks');
		$this->bookmark = new Bookmark();
		$this->user = new User($id);	//DO WE REALLY NEED USER in here?
		$this->userid = $id;
		//echo "userid created: $id |\n";
	}
	
	function add($title,$url,$note=null){
		//user requests to add a new bookmark…
		
		//first: see if bookmark already exists
		$bookmark = $this->bookmark->read(array('url'=>$url));
		if(empty($bookmark)){
			//bookmark does not exist for this url so create a new one!
			$bookmark_id = $this->bookmark->add($title,$url);
		}else $bookmark_id = $bookmark[0]['id'];
		//tie user to bookmark if not already tied
		$user_bookmark = $this->read(array('user_id'=>$this->userid,'bookmark_id'=>$bookmark_id));
		if(empty($user_bookmark)){
			return $this->create(array(	'user_id'		=>$this->userid,
										'bookmark_id'	=>$bookmark_id,
										'note'			=>$note
			));
		}else return false;
	}
	
	function read(){
		//read only bookmarks that belong to this ID
		$s = sprintf("SELECT * FROM %s INNER JOIN bookmarks ON bookmarks.id = user_bookmarks.bookmark_id WHERE user_bookmarks.user_id = %s",$this->table,$this->userid);
		$this->db->doQuery($s);
		return $this->db->resultArray();	
		//SEND THIS STRING TO CRUD
	}

}


