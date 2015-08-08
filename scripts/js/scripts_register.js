/**
 * 
 */

INTENT_SIGNUP = "signup";
INTENT_LOGIN = "login";


window.onload = function() {

	setEventListeners();
	//fillForm();
}


function setEventListeners() {

	//Add Button Event Listeners
	addButtonEventListeners();
	
	//Add Input Listners
	addUsernameInputListeners();
	
	
	
}

function fillForm(){
	setElementValue('input_register_firstname', "Victor ");
	setElementValue('input_register_lastname', "Mwenda");
	setElementValue('input_register_email', "vmwenda.vm@gmail.com");
	setElementValue('input_register_phonenumber', "0718034449");
	setElementValue('input_register_id_number', "32361839");
	setElementValue('input_register_username', "marvik");
	setElementValue('input_register_password', "pass123");
		
}

function addButtonEventListeners(){
	getElement('id_button_get_started').addEventListener('click',get_started,false);
	getElement('id_button_generate_password').addEventListener('click',generate_user_password,false);	
	getElement('id_button_login').addEventListener('click',login_user,false);	
	getElement('id_tag_auth_toggle').addEventListener('click',toggle_auth,false);	
}

function toggle_auth(){
	
	if(getElementHtml('id_tag_auth_toggle')== 'LOG IN'){
		hideElement('page_register');
		showElement('page_login');
		setElementHtml('id_tag_auth_toggle','SIGN UP');
		return;
		}
	if(getElementHtml('id_tag_auth_toggle')== 'SIGN UP'){
		setElementHtml('id_tag_auth_toggle','LOG IN');
		showElement('page_register');
		hideElement('page_login');
		return;
	}
}
function addUsernameInputListeners(){
	getElement('input_register_firstname').addEventListener('input',suggest_username,false);
	getElement('input_register_lastname').addEventListener('input',suggest_username,false);
}

function is_valid_login_form(username,password){
	var formValid = true;
	if(username == ""){
		formValid = false;
	}
	if(password == ""){
		formValid = false;
	}
	return formValid;
}
function login_user(){
	var username = getElementValue('input_login_username');
	var password = getElementValue('input_login_password');
	
	if(is_valid_login_form(username,password)){
		params = "action="+ACTION_QUERY+"&intent="+INTENT_LOGIN+"&username="+username+"&password="+password;
		ajaxCommit(ACTION_QUERY, METHOD_POST, URL_WORKER, params, INTENT_LOGIN);
	}else{
		var errorCount = 0;
		var errors = "";
		if(username == ""){
			errorCount++;
			errors += errorCount+". Missing Username";
		}
		if(password == ""){
			errorCount++;
			errors += errorCount+" . Missing Password ";
		}
		
		alert(errors);
	}
}
function suggest_username(){
	var firstname = getElementValue('input_register_firstname');
	var lastname = getElementValue('input_register_lastname');
	var username = getElementValue('input_register_username');
	
	if(username == ""){
		var suggested_username = "";
		
		if(firstname != ""){
			suggested_username = firstname +"_";
		}
		if(lastname != ""){
			suggested_username += lastname;
		}
		
		//setElementValue('input_register_username', suggested_username);
	}
	
	if(username == (firstname +"_" +lastname)){
		var suggested_username = "";
		
		if(firstname != ""){
			suggested_username = firstname +"_";
		}
		if(lastname != ""){
			suggested_username += lastname;
		}
		
		//setElementValue('input_register_username', suggested_username);
	}
	
}

function is_valid_signup_form(firstname,lastname,email,phonenumber,id_number,username,password){
	var errors = "";
	var errorCount = 0;
	var formValid = true;
	if(firstname == ""){
		formValid = false;
	}
	if(lastname == ""){
		formValid = false;
	}
	if(email == ""){
		formValid = false;
	}
	if(phonenumber == ""){
		formValid = false;
	}
	if(id_number == ""){
		formValid = false;
	}
	if(username == ""){
		formValid = false;
	}
	if(password == ""){
		formValid = false;
	}
	
	
	return formValid;
}
function get_started(){
	
	var firstname = getElementValue('input_register_firstname');
	var lastname = getElementValue('input_register_lastname');
	var email = getElementValue('input_register_email');
	var phonenumber = getElementValue('input_register_phonenumber');
	var id_number = getElementValue('input_register_id_number');
	var username = getElementValue('input_register_username');
	var password = getElementValue('input_register_password');
	
	if(is_valid_signup_form(firstname,lastname,email,phonenumber,id_number,username,password)){
		params = "action="+ACTION_INSERT+"&intent="+INTENT_SIGNUP
		+"&usertype=1" 
		+"&firstname=" +firstname
		+"&lastname=" +lastname
		+"&email=" +email
		+"&phonenumber=" +phonenumber
		+"&id_number=" +id_number
		+"&username=" +username
		+"&password=" +password;

		ajaxCommit(ACTION_INSERT, METHOD_POST, URL_WORKER, params, INTENT_SIGNUP);
	}else{
		var errorCount = 0;
		var errors = ""; 
		if(firstname == ""){
			errorCount++;
			errors += errorCount +". Missing Firstname";
		}
		if(lastname == ""){
		
			errorCount++;
			errors += errorCount +". Missing Lastname ";
		}
		if(email == ""){
			
			errorCount++;
			errors += errorCount +". Missing Email ";
		}
		if(phonenumber == ""){
			
			errorCount++;
			errors += errorCount +". Missing Phonenumber ";
		}
		if(id_number == ""){
			
			errorCount++;
			errors += errorCount +". Missing ID Number/ Passport Number ";
		}
		if(username == ""){
			
			errorCount++;
			errors += errorCount +". Missing Username ";
		}
		if(password == ""){
			
			errorCount++;
			errors += errorCount +". Missing Password ";
		}
		
		alert(errors);
	}
	
}
function generate_user_password(){
	var user_password = generateKeys();
	prompt("Copy your Password", user_password);
	setElementValue('input_register_password', user_password);
}
function onReadyStateChange(action, method, url, params, request, intent) {

	if (request.readyState == 4 && request.status == 200) {
		
		
		
		if (action == ACTION_INSERT) {
				if(intent == INTENT_SIGNUP){
					//alert(request.responseText);
					setCache(CACHE_USER, request.responseText);
					window.close();
				}
		}

		if (action == ACTION_UPDATE) {

		}

		if (action == ACTION_DELETE) {

		}

		if (action == ACTION_QUERY) {
			
				if(intent == INTENT_LOGIN){
					if(request.responseText != "-1"){
						setCache(CACHE_USER, request.responseText);
						setCache(MY_USER_ID, request.responseText);
						window.close();
					}
					if(request.responseText == "-1"){
						alert("Login Failed");
						getElement('input_login_username').style.color="#FF0000";
						getElement('input_login_password').style.color="#FF0000";
					}
					alert(request.responseText);
				}
		}

	}
}