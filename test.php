<?php
session_start();
include('Classes/database.php');
include('Classes/functions.php');
$bookmarks = new Bookmark();
$test = new test();
$user_bookmark = new User_Bookmark($_SESSION['userid']);

echo "<pre>User ID:";
echo $_SESSION['userid']."\n";

//test fetching an array that doesn't exist
$a = $bookmarks->read(array('title'=>'I SHOULD NOT EXIST'));
$test->equals($a[0]['id'],0);

//test fetching an array that doesn't exist returns an empty array
$a = $bookmarks->read(array('title'=>'I SHOULD NOT EXIST'));
$test->equals(empty($a),TRUE);

//Test User creates a bookmark 
$a = $user_bookmark->add('theTitle','http://theURL','aNote');
$test->equals($a,false);


$test->report();
echo "</pre>";


class test{
	public $tests=0;
	public $fails=0;	
	
	function equals($a,$b){
		//test if $a == $b
		$this->tests++;
		if ($a == $b){
			//you passed!
		}else{
			$this->fails++;
			echo "Test ".$this->tests." failed: $a != $b\n";
		}		
	}
	
	function greater($a,$b){
		$this->tests++;
		if ($a > $b){
			//you passed!
		}else{
			$this->fails++;
			echo "Test ".$this->tests." failed: $a !> $b\n";
		}
	}
	
	function report(){
		echo "Tests Run:\t".$this->tests."\nTests Failed:\t".$this->fails;
	}

}