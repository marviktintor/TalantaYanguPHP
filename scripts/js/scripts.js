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
	
}


function setEventListeners() {

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

		}

	}
}