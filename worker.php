<?php

include 'scripts/php/dbapi/db_utils.php';

define ( 'ACTION_QUERY', 'query' );
define ( 'ACTION_INSERT', 'insert' );
define ( 'ACTION_UPDATE', 'update' );
define ( 'ACTION_DELETE', 'delete' );

define ( 'INTENT_SIGNUP', 'signup' );
define ( 'INTENT_LOGIN', 'login' );
define ( 'INTENT_POST_PROJECT', 'post_project' );


define ( 'INTENT_LIKE_PROJECT', 'like_project' );
define ( 'INTENT_UNLIKE_PROJECT', 'unlike_project' );
define ( 'INTENT_FAVORITE_PROJECT', 'favorite_project' );

define ( 'INTENT_LIKE_COMMENT', 'like_comment' );
define ( 'INTENT_UNLIKE_COMMENT', 'unlike_comment' );
define ( 'INTENT_FAVORITE_COMMENT', 'favorite_comment' );

define ( 'INTENT_SEARCH', 'search' );



if(isset($_POST['action'])  && isset($_POST['intent'])){
	
	$intent = $_POST ['intent'];
	$action = $_POST ['action'];
	
	if ($action == ACTION_INSERT) {
		if ($intent == INTENT_SIGNUP) {
			signup();
		}
		if ($intent == INTENT_POST_PROJECT) {
			post_project();
		}
	}
}else{
		echo "Cannot hack into the server";
	}
	

	function post_project(){
		
		$dbutils = new db_utils();
		
		$user = $_POST["user"];
		$tags = $_POST["tags"];
		$title = $_POST["title"];
		$desc = $_POST["desc"];
		
		$table = "";
		 $columns= array("project_title", "project_tags", "project_desc", "id_user"); 
		 $records = array($title,$tags,$desc,$user);
		
	
		if($dbutils->is_exists($table, $columns, $records) == 0){
			$dbutils->insert_records($table, $columns, $records);
		}
		
		fetch_projects();
	}
	
function fetch_projects(){
	
}	
function signup(){

	$usertype = $_POST ["usertype"];
	$firstname = $_POST ["firstname"];
	$lastname = $_POST ["lastname"];
	$email = $_POST ["email"];
	$phonenumber = $_POST ["phonenumber"];
	$id_number = $_POST ["id_number"];
	$username = $_POST ["username"];
	$password = $_POST ["password"];
	
	
	$table = "users"; 
	$columns = array("user_type", "firstname", "lastname", "username", "password", "email", "phone", "id_number");
	$records = array($usertype,$firstname,$lastname,$username,$password,$email,$phonenumber,$id_number);
	$dbutils = new db_utils();
	
	if($dbutils->is_exists($table, $columns, $records) == 0){
		$dbutils->insert_records($table, $columns, $records);
	}
	
	login();
}

function login(){
	$username = $_POST ["username"];
	$password = $_POST ["password"];
	
	$dbutils = new db_utils();
	
	$table = "users";
	$columns = array("username", "password");
	$records = array($username,$password);
	
	if($dbutils->is_exists($table, $columns, $records) == 1){
		$userinfo = $dbutils->query($table, $columns, $records);
		echo $userinfo[0]['id_users'];
	}else echo "-1";
}
?>