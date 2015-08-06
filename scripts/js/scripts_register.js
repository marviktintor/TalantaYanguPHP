/**
 * 
 */

INTENT_SIGNUP = "signup";
INTENT_LOGIN = "login";

INTENT_LIKE_PROJECT = "like_project";
INTENT_UNLIKE_PROJECT = "unlike_project";
INTENT_FAVORITE_PROJECT = "favorite_project";

INTENT_LIKE_COMMENT = "like_comment";
INTENT_UNLIKE_COMMENT = "unlike_comment";
INTENT_FAVORITE_COMMENT = "favorite_comment";

INTENT_SEARCH = "search";

window.onload = function() {

	setEventListeners();
	fillForm();
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
}

function addUsernameInputListeners(){
	getElement('input_register_firstname').addEventListener('input',suggest_username,false);
	getElement('input_register_lastname').addEventListener('input',suggest_username,false);
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
function get_started(){
	
	var firstname = getElementValue('input_register_firstname');
	var lastname = getElementValue('input_register_lastname');
	var email = getElementValue('input_register_email');
	var phonenumber = getElementValue('input_register_phonenumber');
	var id_number = getElementValue('input_register_id_number');
	var username = getElementValue('input_register_username');
	var password = getElementValue('input_register_password');
	
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

		}

	}
}