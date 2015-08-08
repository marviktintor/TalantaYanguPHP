INTENT_VIEW_PERSON_PROFILE = "view_person_profile";
INTENT_ADD_SCHOOL_INFO = "add_school_info";
INTENT_ADD_WORK_INFO = "add_work_info";

window.onload = function(){
	if(getCache(SELECTED_USER_PROFILE) == 'null'){
		window.close();
	}else{
		
		loadUserProfile();
	}
	
	
}

function setEventListeners(){
	if(document.getElementById('id_button_toggle_add_school_info') != null){
		getElement('id_button_toggle_add_school_info').addEventListener('click',toggle_add_school_info,false);
	}
	if(document.getElementById('id_button_add_toggle_work_info') != null){
		getElement('id_button_add_toggle_work_info').addEventListener('click',toggle_add_work_info,false);
	}
	
	if(document.getElementById('id_button_add_school_info_hide') != null){
		getElement('id_button_add_school_info_hide').addEventListener('click',hide_add_school_info,false);
	}
	if(document.getElementById('id_button_add_work_info_hide') != null){
		getElement('id_button_add_work_info_hide').addEventListener('click',hide_add_work_info,false);
	}
	
	
	
	
	getElement('id_button_add_work_info').addEventListener('click',add_work_info,false);
	getElement('id_button_add_school_info').addEventListener('click',add_school_info,false);
	getElement('view_my_projects').addEventListener('click',view_my_projects,false);
}

function view_my_projects (){
	window.open("my_projects.html", "_self");
}
function hide_add_school_info(){
	hideElement('id_view_add_school_info');
}
function hide_add_work_info(){
	hideElement('id_view_add_employment_info');
}
function add_work_info() {

	var company_name = getElementValue('input_work_info_company_name');
	var company_county = getElementValue('input_work_info_company_county');
	var work_role = getElementValue('input_work_info_role');
	var join_date = getElementValue('input_work_info_company_join');
	var leave_date = getElementValue('input_work_info_company_leave');
	
	if(is_valid_work_info(company_name, company_county, work_role,join_date,leave_date)){
		
		user_id = getCache(SELECTED_USER_PROFILE);
		params = "action="+ACTION_INSERT+"&intent="+INTENT_ADD_WORK_INFO+"&company_name=" +company_name +"&company_county=" +company_county +"&work_role=" +work_role
		+"&join_date=" +join_date +"&leave_date=" +leave_date+"&user_profile="+user_id;
		
		ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params, INTENT_ADD_WORK_INFO);
	}else{
		
		var errorCount = 0;
		var errors = '';
		if (company_name == "") {
			errorCount++;
			errors += errorCount +". Missing Company Name";
		}
		
		if (company_county == "") {
			errorCount++;
			errors += errorCount +". Missing County Name";
		}
		
		if (work_role == "") {
			errorCount++;
			errors += errorCount +". Missing Work Role";
		}
		if (join_date == "") {
			errorCount++;
			errors += errorCount +". Missing Join Date";
		}
		if (leave_date == "") {
			errorCount++;
			errors += errorCount +". Missing Leave Date";
		}
		alert(errors);
	}

}

function is_valid_work_info(company_name, company_county, work_role,join_date,leave_date) {
	var formValid = true;
	if (company_name == "") {
		formValid = false;
	}
	if (company_county == "") {
		formValid = false;
	}
	if (work_role == "") {
		formValid = false;
	}
	if (join_date == "") {
		formValid = false;
	}
	if (leave_date == "") {
		formValid = false;
	}

	return formValid;
}
function add_school_info() {

	var school_name = getElementValue('input_school_info_school_name');
	var school_county = getElementValue('input_school_info_school_county');
	var course = getElementValue('input_school_info_course');
	var join_date = getElementValue('input_school_info_school_join');
	var leave_date = getElementValue('input_school_info_school_leave');

if(is_valid_school_info(school_name, school_county, course,join_date,leave_date)){
	user_id = getCache(SELECTED_USER_PROFILE);
	params = "action="+ACTION_INSERT+"&intent="+INTENT_ADD_SCHOOL_INFO+"&school_name=" +school_name +"&school_county=" +school_county +"&course=" +course
	+"&join_date=" +join_date +"&leave_date=" +leave_date+"&user_profile="+user_id;
	
	ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params, INTENT_ADD_SCHOOL_INFO);
	}else{
		var errorCount = 0;
		var errors = '';
		if (school_name == "") {
			errorCount++;
			errors += errorCount +". Missing School Name";
		}
		
		if (school_county == "") {
			errorCount++;
			errors += errorCount +". Missing County Name";
		}
		
		if (course == "") {
			errorCount++;
			errors += errorCount +". Missing Course";
		}
		if (join_date == "") {
			errorCount++;
			errors += errorCount +". Missing Join Date";
		}
		if (leave_date == "") {
			errorCount++;
			errors += errorCount +". Missing Leave Date";
		}

		alert(errors);
	}
}

function is_valid_school_info(school_name, school_county, course,join_date,leave_date){
	var formValid = true;
	if (school_name == "") {
		formValid = false;
	}
	if (school_county == "") {
		formValid = false;
	}
	if (course == "") {
		formValid = false;
	}
	if (join_date == "") {
		formValid = false;
	}
	if (leave_date == "") {
		formValid = false;
	}

	return formValid;
}
function toggle_add_school_info(){
	
	if(getElement('id_view_add_school_info').style.display=='block'){
		hideElement('id_view_add_school_info');
		showElement('id_button_toggle_add_school_info');
		return;
	}
	if(getElement('id_view_add_school_info').style.display=='none'){
		hideElement('id_button_toggle_add_school_info');
		showElement('id_view_add_school_info');
		return;
	}
	if(getElement('id_view_add_school_info').style.display==''){
		hideElement('id_button_toggle_add_school_info');
		showElement('id_view_add_school_info');
		return;
	}
}
function toggle_add_work_info(){
	
	if(getElement('id_view_add_employment_info').style.display=='block'){
		hideElement('id_view_add_employment_info');
		showElement('id_button_add_toggle_work_info');
		return;
	}
	if(getElement('id_view_add_employment_info').style.display=='none'){
		hideElement('id_button_add_toggle_work_info');
		showElement('id_view_add_employment_info');
		return;
	}
	if(getElement('id_view_add_employment_info').style.display==''){
		hideElement('id_button_add_toggle_work_info');
		showElement('id_view_add_employment_info');
		return;
	}
}
function loadUserProfile(){
	var user_id = getCache(MY_USER_ID);
	
	params = "action="+ACTION_QUERY+"&intent="+INTENT_VIEW_PERSON_PROFILE+"&selected_user_id="+user_id;
	ajaxCommit(ACTION_QUERY, METHOD_POST, URL_WORKER, params, INTENT_VIEW_PERSON_PROFILE);
	
}
function onReadyStateChange(action, method, url, params, request, intent) {

	if (request.readyState == 4 && request.status == 200) {

		if (action == ACTION_INSERT) {
			
			if(intent == INTENT_ADD_SCHOOL_INFO){
				loadUserProfile();
				
			}
			if(intent == INTENT_ADD_WORK_INFO ){
				loadUserProfile();
				
			}
		}

		if (action == ACTION_UPDATE) {

		}

		if (action == ACTION_DELETE) {

		}

		if (action == ACTION_QUERY) {
			
			if (intent == INTENT_VIEW_PERSON_PROFILE) { 
				
				setElementHtml('id_user_profile_body', request.responseText);
				setEventListeners();
			}
		}

	}
}