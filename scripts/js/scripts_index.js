FETCHED_PROJECT_HTML = "fetched_project_html";

INTENT_POST_PROJECT = "post_project";
INTENT_FETCH_PROJECTS = "fetch_projects";
INTENT_FETCH_SELECTED_PROJECT = "fetch_selected_project";
INTENT_LEAVE_PROJECT_COMMENT = "leave_project_comments";
INTENT_SEARCH_PROJECT = "search_project";

INTENT_LIKE_PROJECT = "like_project";
INTENT_UNLIKE_PROJECT = "unlike_project";
INTENT_FAVORITE_PROJECT = "favorite_project";

INTENT_LIKE_COMMENT = "like_comment";
INTENT_UNLIKE_COMMENT = "unlike_comment";
INTENT_FAVORITE_COMMENT = "favorite_comment";

INTENT_SEARCH = "search";

window.onload = function() {

	
	
	init();
	get_started();
}

function get_started(){
	
	var cached_user = getCache(CACHE_USER);
	
	if(cached_user == 'null'){
		window.open("register.html", "_blank", "width=100;height=100;");
	}
}

function init(){
	setCache(SELECTED_PROJECT, "-1");
	hideElement('post_project');
	
	setEventListeners();
	//fillForm();
	fetch_projects();
}
function setEventListeners() {

	//Add Button Event Listeners
	addButtonEventListeners();
	
	//Add Input Listeners
	addInputEventListeners();
	
	
	
	
}


function fillForm(){
	setElementValue('input_project_title', "Kenya Innovation Center");
	setElementValue('input_project_tags', "kenya,innovation,ideas,tech,programming,development,software");
	setElementValue('input_project_description', "Create A Project where Investors can meet innovators");
	
		
}

function addButtonEventListeners(){
	
	getElement('id_button_leave_comment').addEventListener('click',post_project_comments,false);
	getElement('id_button_post_project').addEventListener('click',post_project,false);
	getElement('button_toggle_post_project').addEventListener('click',toggle_post_project,false);
	getElement('view_my_profile').addEventListener('click',view_my_profile,false);
	
}

function addInputEventListeners(){
	getElement('input_search_projects').addEventListener('input',search_project,false);
	
}

function toggle_post_project(){
	
	if(getElement('post_project').style.display == 'block'){ 
		document.getElementById('post_project').style.display = 'none';
		document.getElementById('div_leave_comments').style.display = 'block';
		return;
	}
	
	if(getElement('post_project').style.display == 'none'){
		document.getElementById('post_project').style.display = 'block';
		document.getElementById('div_leave_comments').style.display = 'none';
		return;
	}
	
	if(getElement('post_project').style.display == ''){
		document.getElementById('post_project').style.display = 'block';
		document.getElementById('div_leave_comments').style.display = 'none';
	}
	
}
function search_project(){
	var searchKey = getElementValue('input_search_projects');
	params = "action="+ACTION_QUERY+"&intent="+INTENT_SEARCH_PROJECT+"&search_key="+searchKey;
	
	if(searchKey == ""){
		fetch_projects();
	}else{
		ajaxCommit(ACTION_QUERY, METHOD_POST, URL_WORKER, params, INTENT_SEARCH_PROJECT);
	}
	
}
function view_project(project_id){
	
	document.getElementById('post_project').style.display = 'none';
	document.getElementById('div_leave_comments').style.display = 'block';
	
	if(true){
		setCache(SELECTED_PROJECT, project_id);
		params = "action="+ACTION_QUERY+"&intent="+INTENT_FETCH_SELECTED_PROJECT+"&id_project="+project_id;
		ajaxCommit(ACTION_QUERY, METHOD_POST, URL_WORKER, params, INTENT_FETCH_SELECTED_PROJECT);
	}else{ 
		setElementHtml('selected_project_comments', getCache(FETCHED_PROJECT_HTML));
	}
	
}
function fetch_projects(){
	params = "action="+ACTION_QUERY+"&intent="+INTENT_FETCH_PROJECTS
	ajaxCommit(ACTION_QUERY, METHOD_POST, URL_WORKER, params, INTENT_FETCH_PROJECTS);
}

function post_project_comments(){
	if(getCache(SELECTED_PROJECT) == "-1"){
		alert("Please click on a Project");
		return;
	}
	
	var comment = getElementValue('input_leave_comment');
	
	if(comment != ""){
		project_id = getCache(SELECTED_PROJECT)
		params = "action="+ACTION_INSERT+"&intent="+INTENT_LEAVE_PROJECT_COMMENT+"&id_project="+project_id+"&comment="+comment;
		ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params, INTENT_LEAVE_PROJECT_COMMENT);
		
	}else { alert("Failed!Enter your comment(s)");}
}

function view_my_profile(){
	
	
	
	var cached_user = getCache(CACHE_USER);
	
	if(cached_user == 'null'){
		window.open("register.html", "_blank", "width=100;height=100;");
		return;
	}else{
		setCache(MY_USER_ID, getCache(CACHE_USER));
		window.open(URL_MY_PROFILE,"_self");
	}
}
function post_project(){
	
	var tags = getElementValue('input_project_tags');
	var title = getElementValue('input_project_title');
	var desc = getElementValue('input_project_description');
	var cached_user = getCache(CACHE_USER);
	
	
	if(is_valid_project(tags,title,desc)){
		if(cached_user == null){
			window.open("register.html", "_blank", "width=100;height=100;");
			return;
		}
		
		params = "action="+ACTION_INSERT+"&intent="+INTENT_POST_PROJECT
		+"&tags=" +tags
		+"&title=" +title
		+"&desc=" +desc;
		ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params, INTENT_POST_PROJECT);
	}
	
}

function is_valid_project(tags, title, desc) {
	var errors = "";
	var errorCount = 0;
	var formValid = true;
	if (title == "") {
		errorCount++;
		errors +=  errorCount +" Missing Title ";
		formValid = false;
	}
	if (desc == "") {
		errorCount++;
		errors +=  errorCount +" Missing Description ";
		formValid = false;
	}
	if (tags == "") {
		errorCount++;
		errors += errorCount +" Missing Tags ";
		formValid = false;
	}
	
	if(formValid == false){alert(errors);}
	
	
	return formValid;
}


 

function like_project_comment(id_comment){ 
	params = "action="+ACTION_INSERT+"&intent="+INTENT_LIKE_COMMENT +"&id_comment=" +id_comment;
	ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params,INTENT_LIKE_COMMENT);
}
function unlike_project_comment(id_comment){
	params = "action="+ACTION_INSERT+"&intent="+INTENT_UNLIKE_COMMENT +"&id_comment=" +id_comment;
	ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params,INTENT_UNLIKE_COMMENT );
}
function favorite_project_comment(id_comment){
	params = "action="+ACTION_INSERT+"&intent="+INTENT_FAVORITE_COMMENT +"&id_comment=" +id_comment;
	ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params, INTENT_FAVORITE_COMMENT);
}

function like_project(project_id){
	params = "action="+ACTION_INSERT+"&intent="+INTENT_LIKE_PROJECT +"&project_id=" +project_id;
	ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params,INTENT_LIKE_PROJECT );
}
function unlike_project(project_id){
	params = "action="+ACTION_INSERT+"&intent="+ INTENT_UNLIKE_PROJECT+"&project_id=" +project_id;
	ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params,INTENT_UNLIKE_PROJECT );
}
function  favorite_project(project_id){
	params = "action="+ACTION_INSERT+"&intent="+ INTENT_FAVORITE_PROJECT+"&project_id=" +project_id;
	ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params,INTENT_FAVORITE_PROJECT );
}

function view_user_profile(id_user){
	setCache(SELECTED_USER_PROFILE, id_user);
	window.open(URL_PERSON_PROFILE,"_blank","width=100;height=100");
}
function onReadyStateChange(action, method, url, params, request, intent) {

	if (request.readyState == 4 && request.status == 200) {

		if (action == ACTION_INSERT) {
			if (intent == INTENT_POST_PROJECT) {
				setElementHtml('posted_projects', request.responseText);
			}
			if (intent == INTENT_LEAVE_PROJECT_COMMENT) {
				view_project(getCache(SELECTED_PROJECT));
			}
			
			if (intent == INTENT_LIKE_PROJECT || intent == INTENT_UNLIKE_PROJECT || intent == INTENT_FAVORITE_PROJECT ) {
				fetch_projects();
			}
			
			if (intent == INTENT_LIKE_COMMENT || intent == INTENT_UNLIKE_COMMENT || intent == INTENT_FAVORITE_COMMENT) {
				setElementHtml('logger', request.responseText);
				
				view_project(getCache(SELECTED_PROJECT));
			}
		}

		if (action == ACTION_UPDATE) {

		}

		if (action == ACTION_DELETE) {

		}

		if (action == ACTION_QUERY) {
			if (intent == INTENT_FETCH_PROJECTS) {
				setElementHtml('posted_projects', request.responseText);
			}
			if (intent == INTENT_SEARCH_PROJECT) { 
				setElementHtml('posted_projects', request.responseText);
				setElementHtml('selected_project_comments','');
			}
			if (intent == INTENT_FETCH_SELECTED_PROJECT) { 
				var fetchedProjectHtml = request.responseText;
				setElementHtml('selected_project_comments', fetchedProjectHtml);
				setCache(FETCHED_PROJECT_HTML, fetchedProjectHtml);
				//fetch_projects();
			}
			
		}

	}
}