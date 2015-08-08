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
define ( 'INTENT_VIEW_PERSON_PROFILE', 'view_person_profile' );
define ( 'INTENT_SEARCH_PROJECT', 'search_project' );

define ( 'INTENT_ADD_SCHOOL_INFO', 'add_school_info' );
define ( 'INTENT_ADD_WORK_INFO', 'add_work_info' );

define ( 'INTENT_FETCH_MY_PROJECTS', 'fetch_my_projects' );
define ( 'INTENT_FETCH_MY_SELECTED_PROJECT', 'fetch_my_selected_project' );


define ( 'INTENT_LIKE_PROJECT', 'like_project' );
define ( 'INTENT_UNLIKE_PROJECT', 'unlike_project' );
define ( 'INTENT_FAVORITE_PROJECT', 'favorite_project' );

define ( 'INTENT_LIKE_COMMENT', 'like_comment' );
define ( 'INTENT_UNLIKE_COMMENT', 'unlike_comment' );
define ( 'INTENT_FAVORITE_COMMENT', 'favorite_comment' );

define ( 'INTENT_SEARCH', 'search' );
define ( 'INTENT_SEARCH_MY_PROJECT', 'search_my_projects' );


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
		
		
		if ($intent == INTENT_LIKE_PROJECT) {
			like_project(false);
		}
		if ($intent == INTENT_UNLIKE_PROJECT) {
			unlike_project(false);
		}
		if ($intent == INTENT_FAVORITE_PROJECT) {
			favorite_project();
		}
		if ($intent == INTENT_LIKE_COMMENT) { 
			like_project_comment(false);
		}
		if ($intent == INTENT_UNLIKE_COMMENT) {
			unlike_project_comment(false);
		}
		if ($intent == INTENT_FAVORITE_COMMENT) {
			favorite_project_comment();
		}

		if ($intent == INTENT_ADD_SCHOOL_INFO) {
			addSchoolInfo();
		}
		if ($intent == INTENT_ADD_WORK_INFO) {
			addWorkInfo();
		}
	}
	if ($action == ACTION_QUERY) {
		if ($intent == INTENT_FETCH_PROJECTS) {
			fetch_projects(false,false);
		}
		if ($intent == INTENT_FETCH_MY_PROJECTS) {
			fetch_projects(false,true);
		}
		if ($intent == INTENT_SEARCH_PROJECT) {
			search_projects();
		}
		if ($intent == INTENT_SEARCH_MY_PROJECT) {
			search_projects(true);
		}
		if ($intent == INTENT_FETCH_SELECTED_PROJECT) {
			fetch_project_infos();
		}
		if ($intent == INTENT_FETCH_MY_SELECTED_PROJECT) {
			fetch_project_infos(true);
		}
		if ($intent == INTENT_VIEW_PERSON_PROFILE) {
			show_selected_user_profile();
		}
		if ($intent == INTENT_LOGIN) {
			login();
		}
		
	}
}else{
		echo "Cannot hack into the server";
	}
	
	function addSchoolInfo(){
		
		$school_name = $_POST['school_name'];
		$school_county = $_POST['school_county'];
		
		$table = "schools";
		$columns= array("school_name", "county");
		$records = array($school_name,$school_county);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 0){
			$dbutils->insert_records($table, $columns, $records);
		}
		
		
		$schools = $dbutils->query($table, $columns, $records);
		$id_school = $schools[0]['id_school'];
		
		
		$user_profile = $_POST['user_profile'];
		$course = $_POST['course'];
		$join_date = $_POST['join_date'];
		$leave_date = $_POST['leave_date'];
		
		$table = "school_info";
		$columns= array("id_school", "id_user", "join_date", "course", "leave_date");
		$records = array($id_school,$user_profile,$join_date,$course,$leave_date);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 0){
			$dbutils->insert_records($table, $columns, $records);
		}
		
	}
	function addWorkInfo(){
		
		$company_name = $_POST['company_name'];
		$company_county = $_POST['company_county'];
		
		$table = "company";
		$columns= array("company_name", "county");
		$records = array($company_name,$company_county);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 0){
			$dbutils->insert_records($table, $columns, $records);
		}
		
		$companies = $dbutils->query($table, $columns, $records);
		$id_company = $companies[0]['id_company'];
		
		
		$user_profile = $_POST['user_profile'];
		$work_role = $_POST['work_role'];
		$join_date = $_POST['join_date'];
		$leave_date = $_POST['leave_date'];
		
		$table = "employment_info";
		$columns= array("id_company", "id_user", "start_date", "stop_date", "role", "county");
		$records = array($id_company,$user_profile,$join_date,$leave_date,$work_role,$company_county);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 0){
			$dbutils->insert_records($table, $columns, $records);
		}
		
		
	}
	

	
	function show_selected_user_profile(){
		$user_id = $_POST['selected_user_id'];
		
		$table = "users";
		$columns= array("id_users");
		$records = array($user_id);
		$dbutils = new db_utils();
		
		$user_info = $dbutils->query($table, $columns, $records);
		
		$id_users= $user_info[0]['id_users'];
		$user_type= $user_info[0]['user_type'];
		$firstname= $user_info[0]['firstname'];
		$lastname= $user_info[0]['lastname'];
		$username= $user_info[0]['username'];
		/* $password= $user_info[0]['password']; */
		$email= $user_info[0]['email'];
		$phone= $user_info[0]['phone'];
		$id_number = $user_info[0]['id_number'];
		$commit_time= $user_info[0]['commit_time'];
		
		$school_info = get_user_school_info($id_users);
		$employment_info = get_employment_info($id_users);
		$social_media_info = get_social_media_info($id_users);
		
		
		print_user_profile($id_users,$user_type,$firstname,$lastname,$username,$email,$phone,$commit_time,$school_info,$employment_info,$social_media_info);
	}
	
	function print_user_profile($id_users,$user_type,$firstname,$lastname,$username,$email,$phone,$commit_time,$school_info,$employment_info,$social_media_info){
		echo '<header id="header" style="background: url(\'images/victor_mwenda.jpg\')"></header>
				<div id="main"><span id="test"></span>
					<div id="one" > <h5>'.$firstname.' '.$lastname.'</h5>
						<header class="major"></header>
					</div>	
						<div class="4u$ 12u$(small)">
							<ul class="labeled-icons">
								<li>
									<h6 ><span class="label">Address</span></h6>
								</li>
								<li>
									<h6 ><span class="label">Phone</span> <a href="tel:'.$phone.'">'.$phone.'</a></h6>
								</li>
								<li>
									<h6 ><span class="label">Email</span> <a href="mailto:'.$email.'">'.$email.'</a></h6>
								</li>
							</ul>
						</div>
						<div >
							<h6>About</h6>
							<article class="" id="id_article_about_user"></article>
						</div>
						<div>
							<div >
								<h6>Employment History</h6>
								<label><a class="waves-effect waves-light btn" id="id_button_add_toggle_work_info">Add Work Info</a></label>
								<div>'.$employment_info.'</div>
							'.get_add_work_info_view().'
							</div>
							<div >
								<h6>School History</h6>
								<label><a class="waves-effect waves-light btn" id="id_button_toggle_add_school_info">Add School Info</a></label>
								<div>'.$school_info.'</div>
								'.get_add_school_info_view().'
							</div>
						</div>
					</div>
					<footer id="footer">
						<ul class="icons">
							
						</ul>
						<ul class="copyright">
							<li>&copy; </li><li> <a href="#">Kenya Talents</a></li>
						</ul>
					</footer>
				</div>';
	}
	
	function get_add_school_info_view(){
		return '<div id="id_view_add_school_info" class="card hoverable " style="padding:20px;display:none;">
				
									<input id="input_school_info_school_name" type="text" placeholder="School name" >
									<input id="input_school_info_school_county" type="text" placeholder="County" >
									<input id="input_school_info_course" type="text" placeholder="Course" >
				
									<div style="width:100%;">
										<div style="float:left;  margin:1%; width:48%;">
											<label>Join Date</label>
											<input id="input_school_info_school_join" type="date" placeholder="Join" >
										</div>
										<div style="float:right; margin:1%; width:48%;">
											<label>Leave Date</label>
											<input id="input_school_info_school_leave" type="date" class="datepicker "/>
										</div>
									
									</div>
									<a class="waves-effect waves-light btn" id="id_button_add_school_info">Add School Info</a>
									<a class="waves-effect waves-light btn" id="id_button_add_school_info_hide">Hide</a>
								</div>';
	}
	
	function get_add_work_info_view(){
		 return '<div id="id_view_add_employment_info" class="card hoverable " style="padding:20px;display:none;">
		 		
	<input id="input_work_info_company_name" type="text" placeholder="Company name" >
	<input id="input_work_info_company_county" type="text" placeholder="County" >
	<input id="input_work_info_role" type="text" placeholder="Role" >
				
		<div style="width:100%;">
			<div style="float:left;  margin:1%; width:48%;">
				<label>Join Date</label>
				<input id="input_work_info_company_join" type="date" placeholder="Join" >
			</div>
			<div style="float:right; margin:1%; width:48%;">
				<label>Leave Date</label>
				<input id="input_work_info_company_leave" type="date" class="datepicker "/>
			</div>
		</div>
		 <a class="waves-effect waves-light btn" id="id_button_add_work_info">Add Work Info</a>
		  <a class="waves-effect waves-light btn" id="id_button_add_work_info_hide">Hide</a>
		 		
	</div>';
	} 
	function get_user_school_info($id_users){

		$table = "school_info";
		$columns= array("id_user");
		$records = array($id_users);
		$dbutils = new db_utils();
		
		$school_info = $dbutils->query($table, $columns, $records);
		
		$school_infos = "";
		
		if(count($school_info)>0){
			
			for($i = 0;$i<count($school_info);$i++){
				
				$id_school = $school_info[$i]['id_school'];
				$id_user= $school_info[$i]['id_user'];
				$join_date= $school_info[$i]['join_date'];
				$leave_date= $school_info[$i]['leave_date'];
				$course= $school_info[$i]['course'];
				
				$school_name = get_school_name($id_school);
				
				$school_infos .= populate_school_info($id_school,$join_date,$leave_date,$course,$school_name);
			}
			
		}
		
		if(count($school_info)==0){
			$school_infos = '<div style="margin:20px; padding:15px;" class=" minimal-margin minimal-padding hoverable card-panel teal lighten-2" >
						<h5 style="color:#FFF;">'.get_user_username($id_users).' has not posted any school Info! </h5>
					</div>';
		}
		
		return $school_infos;
	}
	
	
	function get_employment_info($id_user){
		
		$table = "employment_info";
		$columns= array("id_user");
		$records = array($id_user);
		$dbutils = new db_utils();
		
		$employment_info = "";
		
		$employment_infos = $dbutils->query($table, $columns, $records);
		
		if(count($employment_infos)>0){
			for($i = 0;$i <count($employment_infos);$i++){
				$id_company= $employment_infos[$i]['id_company'];
				$id_user= $employment_infos[$i]['id_user'];
				$start_date= $employment_infos[$i]['start_date'];
				$stop_date= $employment_infos[$i]['stop_date'];
				$role= $employment_infos[$i]['role'];
				$county = $employment_infos[$i]['county'];
				
				$employment_info .= populate_employment_info($id_company,$start_date,$stop_date,$role,$county);
			}
			
		}
		if(count($employment_infos)==0){
			$employment_info = '<div style="margin:20px; padding:15px;" class=" minimal-margin minimal-padding hoverable card-panel teal lighten-2" >
						<h5 style="color:#FFF;">'.get_user_username($id_user).' has not posted any employment Info! </h5>
					</div>';
		}
	
		return $employment_info;
	}
	function get_social_media_info($id_users){
		$social_media ='<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
							<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
							<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>';
	}
	function populate_school_info($id_school,$join_date,$leave_date,$course,$school_name){
		return '<div class="card hoverable " style="padding:10px; margin:10px;">
				<label class="right">'.$join_date.' - '.$leave_date.'</label><br />
				<span>'.$course.'</span><br />
				<label class="left">'.$school_name.'</label><br />
				</div>';
		
		
	}
	function populate_employment_info($id_company,$start_date,$stop_date,$role,$county){
		return '<div class="card hoverable " style="padding:10px; margin:10px;">
				<label class="right">'.$start_date.' - '.$stop_date.'</label><br />
				<span>'.$role.'</span><br />
				<label class="left">'.get_company_name($id_company).'</label><br /></div>';
		
		
	}
	function get_school_name($id_school){
		
		$table = "schools";
		$columns= array("id_school");
		$records = array($id_school);
		$dbutils = new db_utils();
		
		$schools = $dbutils->query($table, $columns, $records);
		if(count($schools)>0){
			return $schools[0]['school_name']."(".$schools[0]['county'].")";
		}else return "Unknown County";
	}
	function get_company_name($id_company){
		
		$table = "company";
		$columns= array("id_company");
		$records = array($id_company);
		$dbutils = new db_utils();
		
		$companies = $dbutils->query($table, $columns, $records);
		if(count($companies)>0){
			return $companies[0]['company_name']."(".$companies[0]['county'].")";
		}else return "Unknown County";
	}
	function like_project_comment($check_unlike){
		
		$id_comment = $_POST['id_comment'];
		$user = $_POST['user'];
		/* $comment = $_POST['comment']; */
		$like = 1;
		
		$table = "comments_impressions";
		$columns= array("id_comment", "id_user", "likes");
		$records = array($id_comment,$user,$like);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 1){
			$dbutils->delete_record($table, $columns, $records);
		}else{ 
			if($check_unlike == false){
				$dbutils->insert_records($table, $columns, $records);
				unlike_project_comment(true);
			}
		}
		
		
		
	} 
	function unlike_project_comment($check_unlike){
		$id_comment = $_POST['id_comment'];
		$user = $_POST['user'];
		/* $comment = $_POST['comment']; */
		$unlike = 1;
		
		$table = "comments_impressions";
		$columns= array("id_comment", "id_user", "unlikes");
		$records = array($id_comment,$user,$unlike);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 1){
			$dbutils->delete_record($table, $columns, $records);
		}else{ 
			if($check_unlike == false){
				$dbutils->insert_records($table, $columns, $records);
				like_project_comment(true);
			}
		}
	}
	function favorite_project_comment(){
		$id_comment = $_POST['id_comment'];
		$user = $_POST['user'];
		/* $comment = $_POST['comment']; */
		$favorites = 1;
		
		$table = "comments_impressions";
		$columns= array("id_comment", "id_user", "favorites");
		$records = array($id_comment,$user,$favorites);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 1){
			$dbutils->delete_record($table, $columns, $records);
		}else{ $dbutils->insert_records($table, $columns, $records);}
	}
	
	function like_project($check_unlike){
		
		$id_project = $_POST['project_id'];
		$user = $_POST['user'];
		$likes = 1;
		
		$table = "project_impressions";
		$columns= array("id_project", "id_user", "likes");
		$records = array($id_project,$user,$likes);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 1){
			$dbutils->delete_record($table, $columns, $records);
		}else{ 
			if($check_unlike==false){
				$dbutils->insert_records($table, $columns, $records);
				unlike_project(true);
			}
		}
		
	}
	function unlike_project($check_like){
		$id_project = $_POST['project_id'];
		$user = $_POST['user'];
		$unlikes = 1;
		
		$table = "project_impressions";
		$columns= array("id_project", "id_user", "unlikes");
		$records = array($id_project,$user,$unlikes);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 1){
			$dbutils->delete_record($table, $columns, $records);
		}else{ 
			if($check_like == false){
				$dbutils->insert_records($table, $columns, $records);
				like_project(true);
			}
			
		}
	}
	function  favorite_project(){
		$id_project = $_POST['project_id'];
		$user = $_POST['user'];
		$favorites = 1;
		
		$table = "project_impressions";
		$columns= array("id_project", "id_user", "favorites");
		$records = array($id_project,$user,$favorites);
		$dbutils = new db_utils();
		
		if($dbutils->is_exists($table, $columns, $records) == 1){
			$dbutils->delete_record($table, $columns, $records);
		}else{ $dbutils->insert_records($table, $columns, $records);}
	}
	
	
	function post_project_comments(){
		$project_id = $_POST['id_project'];
		$user = $_POST['user'];
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
	function fetch_project_infos($myproject=false){
		
		$project_id  = $_POST['id_project'];
		
		if($myproject == true){
			analyse_project_data($project_id);
		}
		
		fetch_project_comments($project_id);

		
		
		
	}
	
	function analyse_project_data($project_id){
		
		echo '<div class="card hoverable" style="padding:10px;">'.analyse_project_views($project_id).'</div>';
		echo '<div class="card hoverable" style="padding:10px;> "'.analyse_project_favorites($project_id).'</div>';
		echo '<div class="card hoverable" style="padding:10px;>"'.analyse_project_likes($project_id).'</div>';
		echo '<div class="card hoverable" style="padding:10px;>"'.analyse_project_unlikes($project_id).'</div>';
		echo '<span>Project Comments ('.get_project_comments_count($project_id).')</span><hr />';
		analyse_project_comments($project_id);
	}
	function analyse_project_views($project_id) {
		 
		$impressions_view = "";
		
		$table = "project_views";
		$columns = array("id_project");
		$records = array($project_id);
		$dbutils = new db_utils();
		
		$total_views = get_project_views($project_id);
		
		
		$project_views = $dbutils->query($table, $columns, $records);
		if(count($project_views)>0){
			$impressions_view .= '<span>Project Views ('.($total_views + 1).')</span><table><thead><tr><th data-field="index">#</th><th data-field="username">User</th><th data-field="time">Views</th></tr></thead>';
			for($i = 0;$i<count($project_views);$i++){
				$id_user = $project_views[$i]['id_user'];
				$username = get_user_username($id_user);
				$views = $project_views[$i]['count_views'];
				$impressions_view .= print_impressions_table($id_user,($i + 1),$username,$views);
			}
			$impressions_view .= "</table>";
		}
		if(count($project_views)==0){
			$impressions_view .= '<div style="margin:20px; padding:15px;" class=" minimal-margin minimal-padding hoverable card teal lighten-2" ><h5> This Project has no likes</h5></div>';
		}
		
		return $impressions_view; 
	}
	function analyse_project_favorites($project_id) {
		
		$impressions_view = "";
		
		$table = "project_impressions";
		$columns = array("id_project","favorites");
		$records = array($project_id,"1");
		$dbutils = new db_utils();
		
		$total_favorites = $dbutils->is_exists($table, $columns, $records);
		
		
		$project_favorites = $dbutils->query($table, $columns, $records);
		$impressions_view .= '<span>Project Favorites ('.$total_favorites.')</span><hr /><table class="stripped"><thead><tr><th data-field="index">#</th><th data-field="username">User</th><th data-field="time">Time</th></tr></thead>';
		if(count($project_favorites)>0){
			for($i = 0;$i<count($project_favorites);$i++){
				echo '<tbody>';
				$id_user = $project_favorites[$i]['id_user'];
				$username = get_user_username($id_user);
				$time = get_human_friendly_time($project_favorites[$i]['commit_time']);
				$impressions_view .= print_impressions_table($id_user,($i + 1),$username,$time);
				echo '</tbody>';
			}
		}
		
		$impressions_view .= "</table>";
		if(count($project_favorites)==0){
			$impressions_view .= '<div style="margin:20px; padding:15px;" class=" minimal-margin minimal-padding hoverable card teal lighten-2" ><h5> This Project has not been favorated</h5></div>';
		}
		
		return $impressions_view;
	}
	function analyse_project_likes($project_id) {
		
		
		$impressions_view = "";
		
		$table = "project_impressions";
		$columns = array("id_project","likes");
		$records = array($project_id,"1");
		$dbutils = new db_utils();
		
		$total_likes = $dbutils->is_exists($table, $columns, $records);
		
		
		$project_likes = $dbutils->query($table, $columns, $records);
		$impressions_view .= '<span>Project Likes ('.$total_likes.')</span><hr /><table class="stripped"><thead><tr><th data-field="index">#</th><th data-field="username">User</th><th data-field="time">Time</th></tr></thead>';
			
		if(count($project_likes)>0){
			for($i = 0;$i<count($project_likes);$i++){
				echo '<tbody>';
				$id_user = $project_likes[$i]['id_user'];
				$username = get_user_username($id_user);
				$time = get_human_friendly_time($project_likes[$i]['commit_time']);
				$impressions_view .= print_impressions_table($id_user,($i + 1),$username,$time);
				echo '</tbody>';
			}
			
		}
		$impressions_view .= "</table>";
		if(count($project_likes)==0){
			$impressions_view .= '<div style="margin:20px; padding:15px;" class=" minimal-margin minimal-padding hoverable card teal lighten-2" ><h5> This Project has no likes</h5></div>';
		}
		
		return $impressions_view;
	}
	
	function print_impressions_table($user_id,$index,$username,$time){
		return '<tr><td>'.$index.'</td><td onclick="view_user_profile('.$user_id.');">'.$username.'</td><td>'.$time.'</td></tr>';
	}
	function analyse_project_unlikes($project_id) {

		
		$impressions_view = "";
		
		$table = "project_impressions";
		$columns = array("id_project","unlikes");
		$records = array($project_id,"1");
		$dbutils = new db_utils();
		
		$total_unlikes = $dbutils->is_exists($table, $columns, $records);
		
		
		$project_likes = $dbutils->query($table, $columns, $records);
		$impressions_view .= '<span>Project Unlikes ('.$total_unlikes.')</span><hr /><table class="stripped"><thead><tr><th data-field="index">#</th><th data-field="username">User</th><th data-field="time">Time</th></tr></thead>';
			
		if(count($project_likes)>0){
			for($i = 0;$i<count($project_likes);$i++){
				echo '<tbody>';
				$id_user = $project_likes[$i]['id_user'];
				$username = get_user_username($id_user);
				$time = get_human_friendly_time($project_likes[$i]['commit_time']);
				$impressions_view .= print_impressions_table($id_user,($i + 1),$username,$time);
				echo '</tbody>';
			}
			
		}
		$impressions_view .= "</table>";
		if(count($project_likes)==0){
			$impressions_view .= '<div style="margin:20px; padding:15px;" class=" minimal-margin minimal-padding hoverable card teal lighten-2" ><h5> This Project has no unlikes</h5></div>';
		}
		
		return $impressions_view;
	}
	function analyse_project_comments($project_id) {
	}
	function fetch_project_comments($project_id){
		
		$dbutils = new db_utils();
		
		$id_user = $_POST['user'];
		$table = "project_views";
		$columns= array("id_project","id_user");
		$records = array($project_id,$id_user);
		
		
		if($dbutils -> is_exists($table, $columns, $records) > 0){
			$columns= array("id_project","id_user");
			$records = array($project_id,$id_user);
			$project_views = $dbutils->query($table, $columns, $records);
			$views = $project_views[0]['count_views'];
			
			$columns= array("id_project","id_user","count_views");
			$records = array($project_id,$id_user,$views+1);
			
			$where_columns= array("id_project","id_user","count_views");
			$where_records = array($project_id,$id_user,$views);
			
			$dbutils->update_record($table, $columns, $records, $where_columns, $where_records);
		}
		
		if($dbutils -> is_exists($table, $columns, $records) == 0){
			$columns= array("id_project","id_user","count_views");
			$records = array($project_id,$id_user,1);
			$dbutils->insert_records($table, $columns, $records);
		}
		
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
				$poster_name = get_user_username($id_user);
					
				$likes = get_comment_likes($id_comment);
				$unlikes = get_comment_unlikes($id_comment);
				$favorites = get_comment_favorites($id_comment);
					
				print_comment($id_comment,$comment_text,$likes,$unlikes,$favorites,$id_user,$poster_name,$posted_time);
			}
		}
		
		if( count($comments) == 0){
			echo '<div style="margin:20px; padding:15px;" class=" minimal-margin minimal-padding hoverable card-panel teal lighten-2" >
						<h5> This Project has no comments, be the first to leave a comment</h5></div>';
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
	
	function print_comment($id_comment,$comment_text,$likes,$unlikes,$favorites,$id_poster,$poster_name,$posted_time){
		echo '<div class="card minimal-margin minimal-padding hoverable" >
				<div style="padding:10px;">
					<h6 class="right" style="color:#00b8d4">'.$posted_time.'</h6><br />
					<h6 style="font-size:20px">'.$comment_text.'</h6>
		
					<div class="">			
						<span style="color:#00b0ff">'.$likes.'<img onclick="like_project_comment('.$id_comment.');" class="impressions" src="images/like.png"/></span>
						<span style="color:#e57373">'.$unlikes.'<img onclick="unlike_project_comment('.$id_comment.');" class="impressions" src="images/unlike.png"/></span>
						<span style="color:#ef6c00;">'.$favorites.'<img onclick="favorite_project_comment('.$id_comment.');" class="impressions" src="images/favorite.png"/></span>
						</span>
						<span style="color:#00897b"class="right" onclick="view_user_profile('.$id_poster.');">'.$poster_name.'</span></div>
				</div></div>';
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
		
		fetch_projects(false,false);
	}
	
function search_projects($myproject = false){
	fetch_projects(true,$myproject);
}
function fetch_projects($search,$myprojects = false){
	$dbutils = new db_utils();
	$table = "projects";
	
	if(isset($_POST['my_user_id'])){$id_user = $_POST['my_user_id'];}
	
	$projects = null;
	
	if($search){
		$search_key = $_POST['search_key'];
		
		$columns = array();
		$records= array();
		
		$user_ids = opt_user_id($search_key);
		if(count($user_ids) == 0){
			$columns = array("project_title", "project_tags", "project_desc","id_user");
			$records= array($search_key,$search_key,$search_key,$id_user);
			$projects = $dbutils->search($table, $columns, $records);
		}
		if(count($user_ids) > 0){
			
			for($i = 0;$i<count($user_ids);$i++){
				
				$id_user = $user_ids[$i]['id_users']; 
				$columns = array("project_title", "project_tags", "project_desc","id_user");
				$records= array($search_key,$search_key,$search_key,$id_user);
				$projects = $dbutils->search($table, $columns, $records);
			}
		}
		
		
	}else{
		$columns = array(); $records= array();
		if($myprojects){
			$columns = array("id_user"); $records= array($id_user);
		}
		
		$projects = $dbutils->query($table, $columns, $records);
	}
	
	
	for($i = 0;$i <count($projects);$i++){

		$id_project = $projects[$i]['id_project'];
		
		$title = $projects[$i]['project_title'];
		$desc= $projects[$i]['project_desc'];
		$tags = $projects[$i]['project_tags'];
		
		$post_time = $projects[$i]['commit_time'];
		$posted_time = get_human_friendly_time($post_time);
		
		$poster = $projects[$i]['id_user'];
		$poster_name = get_user_username($poster);
		
		$likes = get_project_likes($id_project);
		$favorates = get_project_favorates($id_project);
		$unlikes = get_project_unlikes($id_project);
		
		$views = get_project_views($id_project);
		
		print_projects($id_project,$title,$desc,$tags,$likes,$favorates,$unlikes,$views,$poster,$poster_name,$posted_time);
	}
}	

function print_projects($id_project,$title,$desc,$tags,$likes,$favorates,$unlikes,$views,$id_poster,$poster_name,$posted_time){
	
	echo '<div class="card minimal-margin minimal-padding hoverable" onclick="view_project('.$id_project.')">
				<div style="padding:10px;">
							<h6 class="right" style="color:#00b8d4">'.$posted_time.'</h6><br />
							<h6 style="font-size:20px">'.$title.'</h6>
				<h6 >'.$desc.'</h6>
				<h6 >'.$tags.'</h6>
							<div class=""><span class="left" style="color:#3e2723">
				<span style="color:#00b0ff">'.get_project_comments_count($id_project).'<img  class="impressions" src="images/comments.png"/></span>			
				<span style="color:#00b0ff">'.$views.'<img onclick="view_project('.$id_project.');" class="impressions" src="images/ic_menu_view.png"/></span>			
				<span style="color:#00b0ff">'.$likes.'<img onclick="like_project('.$id_project.');" class="impressions" src="images/like.png"/></span>
							<span style="color:#e57373">'.$unlikes.'<img onclick="unlike_project('.$id_project.');" class="impressions" src="images/unlike.png"/></span>
							<span style="color:#ef6c00;">'.$favorates.'<img onclick="favorite_project('.$id_project.');" class="impressions" src="images/favorite.png"/></span>
							</span>
							<span style="color:#00897b"class="right" onclick="view_user_profile('.$id_poster.');" >'.$poster_name.'</span></div>
		</div>	</div>';
}

function get_project_comments_count($id_project){

	$table = "comments";
	$columns = array("id_project");
	$records = array($id_project);
	$dbutils = new db_utils();
	
	return $dbutils->is_exists($table, $columns, $records);
}
function get_human_friendly_time($post_time){
	return $post_time;
}

function get_user_username($id_user){
	if($id_user == 0){ $id_user = -1;}
	if(isset($_POST['my_user_id']) ){
		if($_POST['my_user_id'] == $id_user ){
			return "Me";
		}
	}
	$table = "users";
	$columns = array("id_users");
	$records = array($id_user);
	$dbutils = new db_utils();
	
	$views = $dbutils->query($table, $columns, $records);
	return $views[0]['username'];
}

function opt_user_id($search_key){
	
	$table = "users";
	$columns = array( "firstname", "lastname", "username", "email", "phone", "id_number");
	$records = array($search_key,$search_key,$search_key,$search_key,$search_key,$search_key);
	$dbutils = new db_utils();
	return  $dbutils->search($table, $columns, $records);
	
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
	
	$count_views = 0;
	
		$views = $dbutils->query($table, $columns, $records);
		for($i = 0;$i<count($views);$i++){
			$count_views += $views[$i]['count_views'];
		} 
	 return $count_views;
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