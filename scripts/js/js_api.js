//API

//Methods
METHOD_POST = "POST";
METHOD_GET = "GET";

CACHE_USER = "cached_user";
SELECTED_PROJECT = "selected_project";
URL_WORKER ="http://localhost/talantayanguphp/worker.php";

SELECTED_USER_PROFILE="selected_user_profile";
URL_PERSON_PROFILE = "user_profile.html";
URL_MY_PROFILE = "my_profile.html";
MY_USER_ID = "my_user_id";

//Actions
ACTION_QUERY = "query";
ACTION_INSERT = "insert";
ACTION_UPDATE = "update";
ACTION_DELETE = "delete";


//Results
RESULT_SUCCESS = "success";
RESULT_ERROR = "error";


//Status Text
STATUS_TEXT_OK = "OK";


function $(id){
	return document.getElementById(id);
}
function setHtml(id,html){
	$(id).innerHTML = html;
}
function getHtml(id){
	return $(id).innerHTML;
}
function setValue(id,value){
	$(id).value=value;
}
function getValue(id){
	return $(id).value;
}
function setVisibility(id,visibility){
	$(id).style.display = "'"+visibility +"'";
}
function getVisibility(id){
	return $(id).style.display;
}

function setCache(key,value){
	localStorage.setItem(key, value);
}

function getCache(key) {
	return localStorage.getItem(key);
}

//Resusable
function ajaxCommit(action,method,url,params,intent) {

	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
		
	}else{
		request = new ActieveXObject("Microsoft.XMLHTTP");
	}

	request.onreadystatechange = function(){
		onReadyStateChange(action,method,url,params,request,intent);
	}
	
	request.open(method,url);
	
	if(method.toUpperCase()=="POST"){
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		if(getCache(CACHE_USER) == 'null'){
			alert("You need to be logged in");
			return;
		}
		var myUserId = getCache(MY_USER_ID);
		if(myUserId != "" || myUserId != "null"){
			request.send(params	+"&user="+getCache(CACHE_USER)+"&my_user_id="+myUserId );
		}else{request.send(params	+"&user="+getCache(CACHE_USER) );}
		
	}
	if(method.toUpperCase()=="GET"){
		request.send(null);
	}
	
	
}


//Password Generator



function generateKeys() {
	var temp = '';
	var keylist = "?!@#$%^&*()abcdefghijklmnopqrstuvwxyz123456789";
	temp = '';

	for (i = 0; i < 7; i++) {
		temp += keylist.charAt(Math.floor(Math.random() * keylist.length));
	}

	return temp;
}


function getElement(id){
    return document.getElementById(id);
}
function setElementHtml(id,html){
    getElement(id).innerHTML = html;
}
function getElementHtml(id){
    return  getElement(id).innerHTML;
}function setElementValue(id,value){
    getElement(id).value = value;
}
function getElementValue(id){
    return  getElement(id).value;
}
function hideElement(id){
    getElement(id).style.display = 'none';
}
function showElement(id){
    getElement(id).style.display = 'block';
}
function setMargin(id,direction,margin){
    if(direction == 'none'){
        getElement(id).style.margin = margin+"px";
    } 
    if(direction == 'top'){
        getElement(id).style.marginTop = margin+"px";
    } 
    if(direction == 'right'){
        getElement(id).style.marginRight = margin+"px";
    } 
    if(direction == 'bottom'){
        getElement(id).style.marginBottom = margin+"px";
    } 
    if(direction == 'left'){
        getElement(id).style.marginLeft = margin+"px";
    }
}
