<div style="width: <?= $this->context->width?>;
    height: <?= $this->context->height?>">
    <div id="<?= $this->context->mapCanvas?>" style="width:100%; height:100%"></div>
</div>
<script>
    var gMarker;
    var map;
    function initialize() {
        var geocoder = new google.maps.Geocoder();
        window.map = new google.maps.Map(document.getElementById("<?= $this->context->mapCanvas?>"),
            {
                <?php if (!empty($this->context->mapOptions) && is_array($this->context->mapOptions)): ?>
                <?php foreach ($this->context->mapOptions as $mapOptionKey => $mapOption): ?>
                <?=$mapOptionKey?>: <?=$mapOption?>,
                <?php endforeach; ?>
                <?php endif; ?>
                zoom: <?= $this->context->zoom ?>,
                mapTypeId: google.maps.MapTypeId.<?= $this->context->mapType ?>,
                center: new google.maps.LatLng(0, 0)
            }
        );

        var latInput = document.getElementById('<?= $this->context->latInput?>').value;
        var lngInput = document.getElementById('<?= $this->context->lngInput?>').value;
        //console.log(latInput);

        if (latInput != "" && lngInput !="" ){
            var center = new google.maps.LatLng(latInput, lngInput);
            gMarker = new google.maps.Marker({
                <?php if (!empty($this->context->markerOptions) && is_array($this->context->markerOptions)): ?>
                <?php foreach ($this->context->markerOptions as $markerOptionKey => $markerOption): ?>
                <?=$markerOptionKey?>: <?=$markerOption?>,
                <?php endforeach; ?>
                <?php endif; ?>
                map: map,
                draggable: true,
                position: center
              });

            window.map.setCenter(center);

        }else{

            <?php if (is_array($this->context->center)): ?>
            var center = new google.maps.LatLng(<?= $this->context->center[0] ?>, <?= $this->context->center[1] ?>);
            gMarker = new google.maps.Marker({
                <?php if (!empty($this->context->markerOptions) && is_array($this->context->markerOptions)): ?>
                <?php foreach ($this->context->markerOptions as $markerOptionKey => $markerOption): ?>
                <?=$markerOptionKey?>: <?=$markerOption?>,
                <?php endforeach; ?>
                <?php endif; ?>
                map: map,
                draggable: true,
                position: center
              });

            window.map.setCenter(center);
            <?php else: ?>
            geocoder.geocode({
                "address": "<?= $this->context->center ?>"
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    window.map.setCenter(results[0].geometry.location);
                }
            });
            <?php endif; ?>
        }

        google.maps.event.addListener(gMarker,'dragend',function(event){
            //console.log(event);
            document.getElementById('<?= $this->context->latInput?>').value =event.latLng.lat();
            document.getElementById('<?= $this->context->lngInput?>').value =event.latLng.lng();
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('<?= $this->context->addressInput?>');
        var searchBox = new google.maps.places.SearchBox(input);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
              // delete old marker
              if (typeof gMarker !== 'undefined'){
                gMarker.setMap(null);
              }

              gMarker = new google.maps.Marker({
                  <?php if (!empty($this->context->markerOptions) && is_array($this->context->markerOptions)): ?>
                  <?php foreach ($this->context->markerOptions as $markerOptionKey => $markerOption): ?>
                  <?=$markerOptionKey?>: <?=$markerOption?>,
                  <?php endforeach; ?>
                  <?php endif; ?>
                  map: map,
                  draggable: true,
                  title: place.name,
                  position: place.geometry.location
                });
                window.map.setCenter(place.geometry.location);

            // get gountry from places object
            for(var i = 0; i < place.address_components.length; i += 1) {
              var addressObj = place.address_components[i];
              for(var j = 0; j < addressObj.types.length; j += 1) {
                <?php if (!empty($this->context->countryInput)):?>
                if (addressObj.types[j] === 'country') {
                  //console.log(addressObj.types[j]); // confirm that this is 'country'
                  //console.log(addressObj.long_name); // confirm that this is the country name
                  document.getElementById('<?= $this->context->countryInput?>').value = addressObj.long_name;
                }
                <?php endif; ?>
              }
            }
            // put lat lng
            document.getElementById('<?= $this->context->latInput?>').value = gMarker.getPosition().lat();
            document.getElementById('<?= $this->context->lngInput?>').value = gMarker.getPosition().lng();

            google.maps.event.addListener(gMarker,'dragend',function(event){
                //console.log(event);
                document.getElementById('<?= $this->context->latInput?>').value =event.latLng.lat();
                document.getElementById('<?= $this->context->lngInput?>').value =event.latLng.lng();
            });

            //markers.push(marker);

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

    function loadScript() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "https://maps.googleapis.com/maps/api/js?key=<?= $this->context->apiKey ?>&sensor=<?= $this->context->sensor ?>&libraries=places&callback=initialize";
        document.body.appendChild(script);
    }
    window.onload = loadScript;
</script>
