$('.page').live('pagecreate',function(event){
	if ("WebSocket" in window) {
	    host = "localhost:7777";
	    conn = new WebSocket("ws://"+host+"/");
	    conn.onmessage = function(evt) {
		postMessage(evt.data);
	    };
	
	    conn.onerror = function() {
	    };
	
	    conn.onclose = function() {
	        conn = false;
	    };
	
	    conn.onopen = function() { 
	        //alert("You are connected");
	    };
	}

});

var latitude = false;
var longitude = false;

function postMessage(msg) {
	var messageData = JSON.parse(msg);
	
	if(geo_position_js.init()) {
		geo_position_js.getCurrentPosition(showPosition, console.log("Couldn't get location"));
	}

	if(notificationCheck(messageData.latitude, messageData.longitude, messageData.categories)) {
		apprise(messageData.message);
	}

	// Save message localy
	if(true == supportsLocalStorage()) {
		var localNotifications = localStorage.notifications;
		if(undefined == localNotifications) {
			localNotifications = new Array();
		} else {
			localNotifications = localNotifications.split(',');
		}
		localNotifications.push(messageData.message);
		localStorage.notifications = localNotifications;
	}
}

var showPosition = function(p) {
	latitude = p.coords.latitude;
	longitude = p.coords.longitude;
}

// Returns true if notification location is within users defined area range
var notificationCheck = function(latitude, longitude, categories) {
	if(false == supportsLocalStorage()) {
		return true;
	}
	if(undefined == localStorage.notificationEnabled || !localStorage.notificationEnabled) {
		return false;
	}
	if(undefined == localStorage.notificationArea) {
		return true;	
	}
	var notificationArea = localStorage.notificationArea;
	if(undefined == localStorage.notificationCategories) {
		return true
	}
	// Check notification distance
	var notificationCategories = localStorage.notificationCategories.split(',');
	var inArray = false;
	$.each(categories, function(index, value) {
		if($.inArray('"' + value + '"', notificationCategories)) {
			inArray = true;
		}
	});
	return inArray;
}
