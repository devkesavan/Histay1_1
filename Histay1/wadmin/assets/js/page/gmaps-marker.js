"use strict";

// initialize map
var map = new GMaps({
  div: '#map',
  lat: 23.031741,
  lng: 72.518850
});
// Added a marker to the map
map.addMarker({
  lat: 23.078960,
  lng: 72.623013,
  title: 'Airport',
  infoWindow: {
    content: '<h6>Airport</h6><p>Sardar Vallabhbhai Patel International Airport, <br>Ahmedabad</p><p><a target="_blank" href="../../../../../../../../../example.com/index.html">Website</a></p>'
  }
});
