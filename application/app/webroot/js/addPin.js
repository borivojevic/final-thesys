(function( $ ){
	$.fn.mapPositionChanger = function(options) {
		var map;
		var map_marker;

		var map_click = function(pt) {
			map_marker.setPosition(pt.latLng);
			update_position();
		}
		
		var update_position = function() {
			$('#PinLatitude').val(map_marker.getPosition().lat());
			$('#PinLongitude').val(map_marker.getPosition().lng());
			$('#PinZoom').val(map.getZoom());
		}
		
		var lat = 43.3;
		var lon = 21.9;
		var zm = 12;
		if(options.latitude != undefined) {
			lat = options.latitude;
		}
		if(options.longitude != undefined) {
			lon = options.longitude;
		}
		if(options.zoom != undefined) {
			zm = parseInt(options.zoom);
		}
		var latlng = new google.maps.LatLng(lat, lon);
		var mapOptions = {
			zoom: zm,
			center : latlng,
		    disableDefaultUI: true,
		    mapTypeControl : false,
			navigationControl : true,
			navigationControlOptions : {
				style : google.maps.NavigationControlStyle.SMALL
			},
			mapTypeId : google.maps.MapTypeId.ROADMAP	    
		}
		
		return this.each(function() {
			map = new google.maps.Map(this, mapOptions);
		    map_marker = new google.maps.Marker({
		    	position: latlng,
		    	map: map,
		    	draggable: true
		    });
		    
		    google.maps.event.addListener(map_marker, 'dragend', update_position);	    
		    google.maps.event.addListener(map, 'click', map_click);
		});
	};
})( jQuery );

var setupMap = function() {
	var lat = $("#PinLatitude").val();
	var lon = $("#PinLongitude").val();
	var zoom = $("#PinZoom").val();
	if("" != lat && "" != lon && "" != zoom) {
		$("#addPinMap").mapPositionChanger({latitude: lat, longitude: lon, zoom: zoom});
	} else {
		$("#addPinMap").mapPositionChanger({});
	}
}