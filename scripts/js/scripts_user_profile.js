INTENT_VIEW_PERSON_PROFILE = "view_person_profile";

window.onload = function(){
	if(getCache(SELECTED_USER_PROFILE) == 'null'){
		window.close();
	}else{
		
		loadUserProfile();
	}
}

function loadUserProfile(){
	var user_id = getCache(SELECTED_USER_PROFILE);
	params = "action="+ACTION_QUERY+"&intent="+INTENT_VIEW_PERSON_PROFILE+"&selected_user_id="+user_id;
	ajaxCommit(ACTION_QUERY, METHOD_POST, URL_WORKER, params, INTENT_VIEW_PERSON_PROFILE);
	
}
function onReadyStateChange(action, method, url, params, request, intent) {

	if (request.readyState == 4 && request.status == 200) {

		if (action == ACTION_INSERT) {
			
		}

		if (action == ACTION_UPDATE) {

		}

		if (action == ACTION_DELETE) {

		}

		if (action == ACTION_QUERY) {
			
			if (intent == INTENT_VIEW_PERSON_PROFILE) { 
				
				setElementHtml('id_user_profile_body', request.responseText);
			}
		}

	}
}