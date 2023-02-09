var searchInput = 'search_input7';

$(document).ready(function () {

    // var autocomplete;
    // autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
    // 	types: ['geocode']
    // });


    // google.maps.event.addListener(autocomplete, 'place_changed', function () {
    // 	var near_place = autocomplete.getPlace();
    // 	if(document.getElementById('search_input7').value !== "") 
    // 	{
    // 		document.getElementById('loc_lat').value = near_place.geometry.location.lat();
    // 		document.getElementById('loc_long').value = near_place.geometry.location.lng();

    // 		var latit = near_place.geometry.location.lat();
    // 		var m = latit.toFixed(4);

    // 		var longit = near_place.geometry.location.lng();
    // 		var n = longit.toFixed(4);

    // 		document.getElementById('latitude_view').innerHTML = 'Löydettiin sijainti '+ m + ', ';
    // 		document.getElementById('loc_lat').value = m;
    // 		document.getElementById('longitude_view').innerHTML = n;
    // 		document.getElementById('loc_long').value = n;
    // 	}
    // });

});

$(document).on('change', '#' + searchInput, function () {
    //alert('searchinput func executed ');
    document.getElementById('loc_lat').value = '';
    document.getElementById('loc_long').value = '';

    document.getElementById('latitude_view').innerHTML = "";
    document.getElementById('longitude_view').innerHTML = "";
});
