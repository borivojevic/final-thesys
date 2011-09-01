var geolocationTask = false;
var latitude = false;
var longitude = false;

$(document).ready(function(){
	//Start tracking users location
	if (geo_position_js.init()) {
		geolocationTask = setInterval(updateLocation, 10000);
	}
	if ("WebSocket" in window) {
	    host = "46.21.104.5:7777";
	    conn = new WebSocket("ws://"+host+"/");
	    conn.onmessage = function(evt) {
		postMessage(evt.data);
	    };
	
	    conn.onerror = function() {
		console.log('error');
	    };
	
	    conn.onclose = function() {
		console.log('close');
	        conn = false;
	    };
	
	    conn.onopen = function() { 
		console.log('opened');
	        //alert("You are connected");
	    };
	}

});

function postMessage(msg) {
	var messageData = JSON.parse(msg);
	
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

var updateLocation = function() {
	geo_position_js.getCurrentPosition(showPosition, console.log("Couldn't get location"));
}

var showPosition = function(p) {
	latitude = p.coords.latitude;
	longitude = p.coords.longitude;
}

// Returns true if notification location is within users defined area range
var notificationCheck = function(lat, lon, categories) {
	if(false == supportsLocalStorage()) {
		return true;
	}

	if(undefined == localStorage.notificationEnabled || !localStorage.notificationEnabled) {
		return false;
	}

	// Check notification distance
	if(undefined != localStorage.notificationArea && false != latitude && false != longitude) {
		var notificationArea = localStorage.notificationArea;
		var areaDistance = distVincenty(latitude, longitude, lat, lon);
		if(areaDistance > notificationArea) {
			return false;
		}
	}

	// Check notification categories
	var notificationCategories = localStorage.notificationCategories.split(',');
	var inArray = false;
	$.each(categories, function(index, value) {
		if($.inArray('"' + value + '"', notificationCategories)) {
			inArray = true;
		}
	});
	return inArray;
}

function distVincenty(lat1, lon1, lat2, lon2) {
	var R = 6371; // km
	var dLat = (lat2-lat1).toRad();
	var dLon = (lon2-lon1).toRad(); 
	var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon/2) * Math.sin(dLon/2); 
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
	var d = R * c;
	return d;
}

// ---- extend Number object with methods for converting degrees/radians

/** Converts numeric degrees to radians */
if (typeof(Number.prototype.toRad) === "undefined") {
	Number.prototype.toRad = function() {
	return this * Math.PI / 180;
	}
}
