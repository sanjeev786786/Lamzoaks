/* lp gps  */

var geocoderr;

function lpGetGpsLocName(lpcalback){
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position){
			var clat = position.coords.latitude;
			var clong = position.coords.longitude;
			jpCodeLatLng(clat,clong, function(citynamevalue){
			  lpcalback(citynamevalue);
			});
		});
		
	} else { 
		alert("Geolocation is not supported by this browser.");
	}
		
}

function lpgeocodeinitialize() {
    geocoderr = new google.maps.Geocoder();
}

function jpCodeLatLng(lat, lng, lpcitycallback) {
	
	latlng 	 = new google.maps.LatLng(lat, lng),
			geocoderrr = new google.maps.Geocoder();
		geocoderrr.geocode({'latLng': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					for (var i = 0; i < results.length; i++) {
						if (results[i].types[0] === "locality") {
							var city = results[i].address_components[0].short_name;
							var state = results[i].address_components[2].short_name;
							lpcitycallback(city);
						}
					}
				}
				else {console.log("No reverse geocode results.")}
			}
			else {console.log("Geocoder failed: " + status)}
		});
    
}
  
  
  /* test call */
  
  jQuery(document).ready(function(){
	lpgeocodeinitialize();
  });
  
 