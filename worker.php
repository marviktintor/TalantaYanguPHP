<?php

include 'scripts/php/dbapi/db_utils.php';

define ( 'ACTION_QUERY', 'query' );
define ( 'ACTION_INSERT', 'insert' );
define ( 'ACTION_UPDATE', 'update' );
define ( 'ACTION_DELETE', 'delete' );

define ( 'INTENT_SIGNUP', 'signup' );
define ( 'INTENT_LOGIN', 'login' );
define ( 'INTENT_POST_PROJECT', 'post_project' );
define ( 'INTENT_FETCH_PROJECTS', 'fetch_projects' );
define ( 'INTENT_FETCH_SELECTED_PROJECT', 'fetch_selected_project' );
define ( 'INTENT_LEAVE_PROJECT_COMMENT', 'leave_project_comments' );


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
		if ($intent == INTENT_LEAVE_PROJECT_COMMENT) {
			post_project_comments();
		}
	}
	if ($action == ACTION_QUERY) {
		if ($intent == INTENT_FETCH_PROJECTS) {
			fetch_projects();
		}
		if ($intent == INTENT_FETCH_SELECTED_PROJECT) {
			fetch_project_infos();
		}
		
	}
}else{
		echo "Cannot hack into the server";
	}
	
	function post_project_comments(){
		$project_id = $_POST['id_project'];
		$user = $_POST['id_project'];
		$comment = $_POST['comment'];
		
		$table = "comments";
		$columns= array("id_project","id_user","comment_text");
		$records = array($project_id,$user,$comment);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 0){
			$dbutils->insert_records($table, $columns, $records);
		}
		
		fetch_project_infos();
	}
	function fetch_project_infos(){
		
		$project_id  = $_POST['id_project'];
		
		fetch_project_comments($project_id);
		
		
	}
	
	function fetch_project_comments($project_id){
		
		$dbutils = new db_utils();
		
		$table = "comments";
		$columns= array("id_project");
		$records = array($project_id);
		
		$comments = $dbutils->query($table, $columns, $records);
		
		
		if(count($comments)>0){
			for($i = 0;$i < count($comments);$i++){
					
				$id_comment = $comments[$i]['id_comment'];
				$id_project = $comments[$i]['id_project'];
				$comment_text = $comments[$i]['comment_text'];
				$id_user = $comments[$i]['id_user'];
				$commit_time = $comments[$i]['commit_time'];
					
				$posted_time = get_human_friendly_time($commit_time);
				$poster_name = get_poster_username($id_user);
					
				$likes = get_comment_likes($id_comment);
				$unlikes = get_comment_unlikes($id_comment);
				$favorites = get_comment_favorites($id_comment);
					
				print_comment($id_comment,$comment_text,$likes,$unlikes,$favorites,$poster_name,$posted_time);
			}
		}
		
		if( count($comments) == 0){
			echo '<div style="margin:20px; padding:15px;" class=" minimal-margin minimal-padding hoverable card-panel teal lighten-2" >
						<h5> This Project has no comments, be the first to leave a comment</h5>
					</div>';
		}
		
		
	}
	
	function get_comment_likes($id_comment){
		
		$table = "comments_impressions";
		$columns = array("id_comment","likes");
		$records = array($id_comment,"1");
		$dbutils = new db_utils();
		
		return $dbutils->is_exists($table, $columns, $records);
	}
	function get_comment_unlikes($id_comment){
		$table = "comments_impressions";
		$columns = array("id_comment","unlikes");
		$records = array($id_comment,"1");
		$dbutils = new db_utils();
		
		return $dbutils->is_exists($table, $columns, $records);
	}
	function get_comment_favorites($id_comment){
		$table = "comments_impressions";
		$columns = array("id_comment","favorites");
		$records = array($id_comment,"1");
		$dbutils = new db_utils();
		
		return $dbutils->is_exists($table, $columns, $records);
	}	
	
	function print_comment($id_comment,$comment_text,$likes,$unlikes,$favorites,$poster_name,$posted_time){
		echo '<div class="card minimal-margin minimal-padding hoverable" >
<div style="padding:10px;">
			<h6 class="right" style="color:#00b8d4">'.$posted_time.'</h6><br />
			<h6 style="font-size:20px">'.$comment_text.'</h6>

			<div class="">			
<span style="color:#00b0ff">'.$likes.'<img onclick="like_project_comment('.$id_comment.');" class="impressions" src="images/like.png"/></span>
			<span style="color:#e57373">'.$unlikes.'<img onclick="unlike_project_comment('.$id_comment.');" class="impressions" src="images/unlike.png"/></span>
			<span style="color:#ef6c00;">'.$favorites.'<img onclick="favorite_project_comment('.$id_comment.');" class="impressions" src="images/favorite.png"/></span>
			</span>
			<span style="color:#00897b"class="right">'.$poster_name.'</span></div>
		</div>	</div>';
	}
	function post_project(){
		
		$dbutils = new db_utils();
		
		$user = $_POST["user"];
		$tags = $_POST["tags"];
		$title = $_POST["title"];
		$desc = $_POST["desc"];
		
		$table = "projects";
		 $columns= array("project_title", "project_tags", "project_desc", "id_user"); 
		 $records = array($title,$tags,$desc,$user);
		
	
		if($dbutils->is_exists($table, $columns, $records) == 0){
			$dbutils->insert_records($table, $columns, $records);
		}
		
		fetch_projects();
	}
	
function fetch_projects(){
	$dbutils = new db_utils();
	$table = "projects";
	
	$columns = array(); $records= array();
	
	$projects = $dbutils->query($table, $columns, $records);
	
	for($i = 0;$i <count($projects);$i++){

		$id_project = $projects[$i]['id_project'];
		
		$title = $projects[$i]['project_title'];
		$desc= $projects[$i]['project_desc'];
		$tags = $projects[$i]['project_tags'];
		
		$post_time = $projects[$i]['commit_time'];
		$posted_time = get_human_friendly_time($post_time);
		
		$poster = $projects[$i]['id_user'];
		$poster_name = get_poster_username($poster);
		
		$likes = get_project_likes($id_project);
		$favorates = get_project_favorates($id_project);
		$unlikes = get_project_unlikes($id_project);
		
		$views = get_project_views($id_project);
		
		print_projects($id_project,$title,$desc,$tags,$likes,$favorates,$unlikes,$views,$poster_name,$posted_time);
	}
}	

function print_projects($id_project,$title,$desc,$tags,$likes,$favorates,$unlikes,$views,$poster_name,$posted_time){
	
	echo '<div class="card minimal-margin minimal-padding hoverable" onclick="view_project('.$id_project.')">
				<div style="padding:10px;">
							<h6 class="right" style="color:#00b8d4">'.$posted_time.'</h6><br />
							<h6 style="font-size:20px">'.$title.'</h6>
				<h6 >'.$desc.'</h6>
				<h6 >'.$tags.'</h6>
							<div class=""><span class="left" style="color:#3e2723">
				<span style="color:#00b0ff">'.$views.'<img onclick="view_project('.$id_project.');" class="impressions" src="images/ic_menu_view.png"/></span>			
				<span style="color:#00b0ff">'.$likes.'<img onclick="like_project('.$id_project.');" class="impressions" src="images/like.png"/></span>
							<span style="color:#e57373">'.$unlikes.'<img onclick="unlike_project('.$id_project.');" class="impressions" src="images/unlike.png"/></span>
							<span style="color:#ef6c00;">'.$favorates.'<img onclick="favorite_project('.$id_project.');" class="impressions" src="images/favorite.png"/></span>
							</span>
							<span style="color:#00897b"class="right">'.$poster_name.'</span></div>
		</div>	</div>';
}

function get_human_friendly_time($post_time){
	return $post_time;
}
function get_poster_username($poster){
	
	$table = "users";
	$columns = array("id_users");
	$records = array($poster);
	$dbutils = new db_utils();
	
	$views = $dbutils->query($table, $columns, $records);
	return $views[0]['username'];
}
function get_project_likes($id_project){

	$table = "project_impressions";
	$columns = array("id_project","likes");
	$records = array($id_project,"1");
	$dbutils = new db_utils();
	
	return $dbutils->is_exists($table, $columns, $records);
	
}
function get_project_favorates($id_project){
	
	$table = "project_impressions";
	$columns = array("id_project","favorites");
	$records = array($id_project,"1");
	$dbutils = new db_utils();
	
	return $dbutils->is_exists($table, $columns, $records);
}
function get_project_unlikes($id_project){
	
	$table = "project_impressions";
	$columns = array("id_project","unlikes");
	$records = array($id_project,"1");
	$dbutils = new db_utils();
	
	return $dbutils->is_exists($table, $columns, $records);
}

function get_project_views($id_project){

	$table = "project_views";
	$columns = array("id_project");
	$records = array($id_project);
	$dbutils = new db_utils();
	
	if($dbutils->is_exists($table, $columns, $records) > 0){
		$views = $dbutils->query($table, $columns, $records);
		return $views[0]['count_views'];
	}else return 0;
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