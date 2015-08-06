/**
 * 
 */

INTENT_POST_PROJECT = "post_project";
INTENT_FETCH_PROJECTS = "fetch_projects";
INTENT_FETCH_SELECTED_PROJECT = "fetch_selected_project";
INTENT_LEAVE_PROJECT_COMMENT = "leave_project_comments";

INTENT_LIKE_PROJECT = "like_project";
INTENT_UNLIKE_PROJECT = "unlike_project";
INTENT_FAVORITE_PROJECT = "favorite_project";

INTENT_LIKE_COMMENT = "like_comment";
INTENT_UNLIKE_COMMENT = "unlike_comment";
INTENT_FAVORITE_COMMENT = "favorite_comment";

INTENT_SEARCH = "search";

window.onload = function() {

	
	
	init();
}

function init(){
	setCache(SELECTED_PROJECT, "-1");
	hideElement('post_project');
	
	setEventListeners();
	fillForm();
	fetch_projects();
}
function setEventListeners() {

	//Add Button Event Listeners
	addButtonEventListeners();
	
	
	
	
}

function fillForm(){
	setElementValue('input_project_title', "Kenya Innovation Center");
	setElementValue('input_project_tags', "kenya,innovation,ideas,tech,programming,development,software");
	setElementValue('input_project_description', "Create A Project where Investors can meet innovators");
	
		
}

function addButtonEventListeners(){
	getElement('id_button_post_project').addEventListener('click',post_project,false);
	getElement('id_button_leave_comment').addEventListener('click',post_project_comments,false);
	
}

function view_project(project_id){
	setCache(SELECTED_PROJECT, project_id);
	params = "action="+ACTION_QUERY+"&intent="+INTENT_FETCH_SELECTED_PROJECT+"&id_project="+project_id;
	ajaxCommit(ACTION_QUERY, METHOD_POST, URL_WORKER, params, INTENT_FETCH_SELECTED_PROJECT);
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
			if (intent == INTENT_FETCH_SELECTED_PROJECT) { 
				setElementHtml('selected_project_comments', request.responseText);
				fetch_projects();
			}
		}

	}
}