<!DOCTYPE html>
<html>
  <head>
  <style>
    #map-canvas { width:500px; height:400px; }
    .layer-wizard-search-label { font-family: sans-serif };
  </style>
  <script type="text/javascript"
    src="http://maps.google.com/maps/api/js?sensor=false">
  </script>
  <script type="text/javascript">
    var map;
    var layer_0;
    function initialize() {
      map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: new google.maps.LatLng(24.822204088945938, 121.1627469332275),
        zoom: 9
      });
      var style = [
        {
          featureType: 'all',
          elementType: 'all',
          stylers: [
            { saturation: 30 }
          ]
        }
      ];
      var styledMapType = new google.maps.StyledMapType(style, {
        map: map,
        name: 'Styled Map'
      });
      map.mapTypes.set('map-style', styledMapType);
      map.setMapTypeId('map-style');
      layer_0 = new google.maps.FusionTablesLayer({
        query: {
          select: "col16",
          from: "1w7eIpXZ_rkCv-b3TdZtomJxoY3OHEiofRFQVcJxA"
        },
        map: map,
        styleId: 2,
        templateId: 2
      });
    }
    function changeMap_0() {
      var whereClause;
      var searchString = document.getElementById('search-string_0').value.replace(/'/g, "\\'");
      if (searchString != '--Select--') {
        whereClause = "'C_Name' CONTAINS IGNORING CASE '" + searchString + "'";
      }
      layer_0.setOptions({
        query: {
          select: "col16",
          from: "1w7eIpXZ_rkCv-b3TdZtomJxoY3OHEiofRFQVcJxA",
          where: whereClause
        }
      });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
  </head>
  <body>
    <div id="map-canvas"></div>
    <div style="margin-top: 10px;">
      <label class="layer-wizard-search-label">
        Villeage
        <input type="text" id="search-string_0">
        <input type="button" onclick="changeMap_0()" value="Search">
      </label> 
    </div>
  </body>
</html>
