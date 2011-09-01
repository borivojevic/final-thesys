var infowindow;
(function( $ ){
	$.fn.pinMap = function(options) {
		var map;
		var markers = new Array();
		var positionMarker = null;
		var last_position = null;
		var locations = new Array();
		var geolocationTask = null;
		
		var latlng = new google.maps.LatLng(43.32, 21.9);
		var mapOptions = {
			zoom : 15,
			center : latlng,
			mapTypeControl : false,
			navigationControl : true,
			navigationControlOptions : {
				style : google.maps.NavigationControlStyle.SMALL
			},
			mapTypeId : google.maps.MapTypeId.ROADMAP
		}
		// var options = $.extend(mapOptions, options);
		
		var updateMarkers = function() {
			var bounds = map.getBounds();
			var southWest = bounds.getSouthWest();
			var northEast = bounds.getNorthEast();
			var url = 'pins/list_markers'
					+ '?sw_lat=' + southWest.lat()
					+ '&sw_lon=' + southWest.lng()
					+ '&ne_lat=' + northEast.lat()
					+ '&ne_lon=' + northEast.lng();
			
			var name = getParameterByName('name');
			if(name != "") {
				url += '&name=' + name;
			}
			var category = getParameterByName('category');
			if(category != "") {
				url += '&category=' + category;
			}
			
			$.getJSON(url, function(data) {
				$.each(data.markers, function(index, data) {
					pin = data.marker;
					if($.inArray(pin.id, markers) != -1) {
						return;
					}
					markers.push(pin.id);

					var latlng = new google.maps.LatLng(
						parseFloat(pin.latitude),
						parseFloat(pin.longitude));

					if('pin' == pin.type) {
						var category_ids = pin.category_ids.split(',');
						var category_id = parseInt(category_ids[category_ids.length-1]);
						var image = new google.maps.MarkerImage(get_marker_icon(category_id));

						var marker = new google.maps.Marker({
							position : latlng,
							map : map,
							flat : true,
							cursor : 'pointer',
							pin_id : pin.id,
							title: pin.name,
							icon: image
						});
						
						var contentString = '<div id="content">'+
						'<b>' + pin.name + '</b>'+
						'<div id="bodyContent">'+
							'<p><b>Kategorija:</b> ' + pin.category + '</p>'+
							'<p><b>Adresa:</b> ' + pin.address + '</p>'+
							'<p><b>Telefon:</b> ' + pin.telephone + '</p>'+
						'<p><b>Radno vreme:</b> ' + pin.work_hours + '</p>'+
						'</div>'+
						'</div>';
					}
					
					if('message' == pin.type) {
						var image = new google.maps.MarkerImage('/img/markers/comment.png');

						var marker = new google.maps.Marker({
							position : latlng,
							map : map,
							flat : true,
							cursor : 'pointer',
							pin_id : pin.id,
							title: 'Poruka',
							icon: image
						});
						
						var contentString = '<div id="content">'+
						'<b>Poruka</b>'+
						'<div id="bodyContent">'+ pin.text + '</div>'+
						'</div>';
					}
			        
				    	google.maps.event.addListener(marker, 'click', function() {
						if (infowindow) infowindow.close();
						infowindow = new google.maps.InfoWindow({
							content: contentString,
							maxWidth: 480,
							maxHeight: 600
						});
						infowindow.open(map, marker);
				    	});
				});
			});
		}

		var get_marker_icon = function(category_id) {
			var icon_path = 'img/markers/';
			switch(category_id)
			{
			case 1:
				icon_path += 'restaurant.png';
				break;
			case 2:
				icon_path += 'restaurant_fish.png';
				break;
			case 3:
				icon_path += 'restaurant_italian.png';
				break;
			case 4:
				icon_path += 'restaurant_chinese.png';
				break;
			case 5:
				icon_path += 'candy.png';
				break;
			case 6:
				icon_path += 'bread.png';
				break;
			case 7:
				icon_path += 'barbecue.png';
				break;
			case 8:
				icon_path += 'liquor.png';
				break;
			case 9:
				icon_path += 'fastfood.png';
				break;
			case 10:
				icon_path += 'pizzaria.png';
				break;
			default:
				icon_path += 'restaurant.png';
			}
			return icon_path;
		}
		
		var update_location = function() {
			geo_position_js.getCurrentPosition(show_position, console.log("Couldn't get location"));
		}
		
		var simulate_location = function() {
			if (locations.length == 0) {
				return;
			}
			var p = locations.pop();
			show_position(p);
		}
		
		var show_position = function(p) {
			if (last_position && last_position.coords.latitude == p.coords.latitude
					&& last_position.coords.longitude == p.coords.longitude) {
				console.log("User has not moved,checking again in 2s");
				return;
			}

			last_position = p;
			var pos = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
			map.setCenter(pos);
			map.setZoom(18);
			
			
			if (null != positionMarker) {
				positionMarker.setMap(map);
				positionMarker.setPosition(pos);
				return;
			}

			positionMarker = new google.maps.Marker({
				position : pos,
				map : map,
				title : "You are here"
			});
		}
		
		var createControl = function(text, title, func) {
			var controlDiv = document.createElement('DIV');
//			Set CSS styles for the DIV containing the control
//			Setting padding to 5 px will offset the control
//			from the edge of the map
			controlDiv.style.padding = '5px';

//			Set CSS for the control border
			var controlUI = document.createElement('DIV');
			controlUI.style.backgroundColor = 'white';
			controlUI.style.borderStyle = 'solid';
			controlUI.style.borderWidth = '2px';
			controlUI.style.cursor = 'pointer';
			controlUI.style.textAlign = 'center';
			controlUI.title = title;
			controlDiv.appendChild(controlUI);

//			Set CSS for the control interior
			var controlText = document.createElement('DIV');
			controlText.style.fontFamily = 'Arial,sans-serif';
			controlText.style.fontSize = '12px';
			controlText.style.paddingLeft = '4px';
			controlText.style.paddingRight = '4px';
			controlText.innerHTML = text;
			controlUI.appendChild(controlText);

//			Setup the click event listeners: simply set the map to Chicago
			google.maps.event.addDomListener(controlUI, 'click', func);
			
			controlDiv.index = 1;
			map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);
		}
		
		var startTracking = function() {
			if (geo_position_js.init()) {
				geolocationTask = setInterval(update_location, 2000);
			} else {
				alert('Geolokacija nije dostupna')
			}
		}
		
		var stopTracking = function() {
			clearInterval(geolocationTask);
			if(null != positionMarker) {
				positionMarker.setMap(null);
			}
		}
		
		var startSimulation = function() {
			$.getJSON('coordinates.json', function(data) {
				$.each(data.coordinates, function(key, val) {
					locations.push({
						coords : {
							latitude : val.lat,
							longitude : val.lon
						}
					});
				});
				geolocationTask = setInterval(simulate_location, 200);
			});
		}
		
		this.each(function() {
			map = new google.maps.Map(this, mapOptions);
			createControl('Prekini pracenje', 'Klikni ovde da iskljucis prikazivanje lokacije', stopTracking);
			createControl('Prati moju lokaciju', 'Klikni ovde da bi ti se prikazala trenutna lokacija', startTracking);
			
			createControl('Prekini simulaciju', 'Klikni ovde da iskljucis simulaciju kretanja', stopTracking);
			createControl('Pokreni simulaciju', 'Klikni ovde da pokrenes simulaciju kretanja', startSimulation);
			
			google.maps.event.addListener(map, 'idle', function() {
				updateMarkers();
			});
		});

		return {
		    setCategories: function(categories) {
		    	console.log(categories);
		    },
		    setCenter: function(latitude, longitude, zoom) {
		    	var latlng = new google.maps.LatLng(
		    		parseFloat(latitude),
		    		parseFloat(longitude)
	    		);
		    	map.setCenter(latlng);
		    	map.setZoom(zoom);
		    }
		}

	};

})( jQuery );

(function( $ ){
	$.fn.pinSearch = function(pinPinMap) {
		return this.each(function() {
			$(this).autocomplete({
			    source: function( request, response ) {
					$.ajax({
						url: "pins/search/",
						dataType: "json",
					     data: {
							term: request.term
					    },
						success: function(data) {
			                response($.map(data, function(item) {
			                    return {
			                        label: item.Pin.name,
			                        value: item.Pin.name,
			                        latitude: item.Pin.latitude,
			                        longitude: item.Pin.longitude
			                    }
			                }))
			            }
					});
				},
				minLength: 2,
			    select: function(event, ui) {
					var lat = ui.item.latitude;
					var lon = ui.item.longitude;
					pinPinMap.setCenter(lat, lon, 18);
				}
			});
		});
	};
})( jQuery );

function getParameterByName( name ) {
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}
