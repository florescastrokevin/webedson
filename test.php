<script src="jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places" type="text/javascript" ></script>

<div class="row">
                    <input type="text" name="origen" id="address" class="form-control" />
                </div>
                <div class="row">
                    <div id="mi_ubic" style="width:100%;height:393px;margin-top:15px"></div>
                    <input type="hidden" id="lat_pos" name="lat_pos" value="">
                    <input type="hidden" id="lng_pos" name="lng_pos" value="">
</div>

<script type="text/javascript">
                $(document).ready(function(e){
    
    /* seleccionar ubicacion en una aventura*/
    if ($("#lat_pos").length !== 0 && $("#lng_pos").length !== 0) {

        var lat, lng;
        ($("#lat_pos").val() === "") ? lat = -11.54932570 : lat = $("#lat_pos").val();
        ($("#lng_pos").val() === "") ? lng = -77.541503906 : lng = $("#lng_pos").val();

        var myPos = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            center: myPos,
            zoom:12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        var map = new google.maps.Map(document.getElementById('mi_ubic'), mapOptions);
        var input = (document.getElementById('address'));
        
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);
        var infowindow = new google.maps.InfoWindow();
        var markerNew = new google.maps.Marker({

            map: map,
            draggable: true,
            icon: new google.maps.MarkerImage('aplication/webroot/imgs/icon_location.png'),
            position: new google.maps.LatLng(lat, lng)

        });

        google.maps.event.addListener(markerNew, 'mouseout', toggleBounce);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {

            infowindow.close();
            markerNew.setVisible(false);
            //            input.className = '';
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // Inform the user that the place was not found and return.
                input.className = 'notfound';
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }

            markerNew.setPosition(place.geometry.location);
            toggleBounce();
            markerNew.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                            (place.address_components[0] && place.address_components[0].short_name || ''),
                            (place.address_components[1] && place.address_components[1].short_name || ''),
                            (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, markerNew);
        });

        /*Animación para seleccionar ubicación*/
        google.maps.event.addListener(map, 'click', function(e) {
            placeMarker(e.latLng, map);
        });

        $("#address").keypress(function(e) {
            if (e.keyCode == 13) {
                e.stopPropagation();
                return false;
            }
        });
    }

    function placeMarker(position, map) {
        markerNew.setMap(null)
        markerNew.setMap(null);
        markerNew = new google.maps.Marker({
            map: map,
            draggable: true,
            icon: new google.maps.MarkerImage('aplication/webroot/imgs/icon_location.png'),
            position: position
        });

        google.maps.event.addListener(markerNew, 'mouseout', toggleBounce);//map.panTo(position); Efecto movimiento con el click
    }

    function toggleBounce() {
        //Capturo lo posicion al mover el icono del mapa
        var count = 0;
        $.each(markerNew.getPosition(), function(i, v) {
            if (count == 0) {//LB
                $("#lat_pos").val(v);
                $("#lat_posicion").val(v);
            } else if (count == 1) {//KB
                $("#lng_pos").val(v);
                $("#lng_posicion").val(v);
                return false;
            }
            count++;
        });
    }
 });                       
</script>