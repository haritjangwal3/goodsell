<script>
    function initMap() {
        var location = {lat: -40.900558, lng: 174.885971};
        var map =  new google.maps.Map(document.getElementById("map"), {zoom: -4, center: location});
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHCf7rMeaPuJ6kZ79eOK6tlgEnGp2STTU&callback=initMap"
  type="text/javascript"></script>
<div id="map">
</div>

