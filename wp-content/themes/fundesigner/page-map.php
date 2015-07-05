<?php
/*
Template Name: MAP
*/
get_header();
?>
<h1>
  <?php the_title(); ?>
</h1>
<div class="content">
  <div id="map" style="width: 400px; height: 400px;" class="maplocation"></div>
  <?php
  $args = array(
	  'post_type' => 'post',
	  'posts_per_page'	=> -1
  );
// query
$wp_query = new WP_Query( $args );
$NUM = 0;


$myincludeurl = get_bloginfo("template_url"); 
$myincludeurl = $myincludeurl . '/fusiontips.js';
$myincludeurl = substr($myincludeurl, -43);
?>

<script src="<?= $myincludeurl; ?>" type="text/javascript"></script>

  <script type="text/javascript">
var templateUrl = '<?= get_bloginfo("template_url"); ?>';

/* Improve user address add marker start*/
	var g_loc;
	var g_address;
	//var lo2;

 	<?php 
		 $argsuser = array(
			'role'         => 'subscriber',
		 ); 


 		$roles = get_users( $argsuser ); 
		$i = 0;
		foreach ( $roles as $user ) {
			$address = $user->rpr_address ;
		?>
			getlanlng("<?php echo $address ?>", function() {
          			getlandone();
        		});
	<?php
		$i++;
		}
	?>




/* Improve user address add marker end*/


    var locations = [<?php while( $wp_query->have_posts() ){
	$wp_query->the_post();
    $location = get_field('carte_google'); // IMPORTANT << Change this for your Google map field name !!!!!!?>

['<?php the_title(); ?>', <?php echo $location['lat']; ?>, <?php echo $location['lng'];?>, <?php $NUM++ ?>],
   <?php } ?> ];
   
   
	var colors = ['#FF0000', '#00FF00', '#0000FF', '#FFFF00'];
    var map = new google.maps.Map(document.getElementById('map'), { 
      zoom: 7, /*Here you change zoom for your map*/
      center: new google.maps.LatLng(23.802140, 121.004623), /*Here you change center map first location*/
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;



/*FusionTable for non api key usage Start*/
// Define the LatLng coordinates for the polygon.

/*
	var layer = new google.maps.FusionTablesLayer({
		query: {
		  select: 'geometry',
		  from: '1luO9T2YvyPwp3GLRtLZjUr9FlV3Bt0pC7Ojv8iX_',
		  where: "'C_Name' = '桃園市'"
		},
			map: map,
          suppressInfoWindows: true
	  });

		google.maps.event.addListener(layer, 'click', function(event) {
			zoommap(event);	  
		});
		 google.maps.event.addListener(layer, 'mouseover', function() {
              this.setOptions({fillOpacity: 1});
            });

		google.maps.event.addListener(layer, 'mouseout', function() {
		  this.setOptions({fillOpacity: 0.3});
		  });

		
		 // layer.setMap(map);
		  
		  var layer2 = new google.maps.FusionTablesLayer({
		query: {
		  select: 'geometry',
		  from: '1luO9T2YvyPwp3GLRtLZjUr9FlV3Bt0pC7Ojv8iX_',
		  where: "'C_Name' = '臺北市'"
		},
			map: map,
          suppressInfoWindows: true
	  });

	  layer2.enableMapTips({
        select: "'C_Name'", // list of columns to query, typially need only one column.
        from: '1luO9T2YvyPwp3GLRtLZjUr9FlV3Bt0pC7Ojv8iX_', // fusion table name
        geometryColumn: 'geometry', // geometry column name
        suppressMapTips: true, // optional, whether to show map tips. default false
        //delay: 1, // milliseconds mouse pause before send a server query. default 300.
        tolerance: 6 // tolerance in pixel around mouse. default is 6.
        });
	  
		  //here's the pseudo-hover
		google.maps.event.addListener(layer2, 'mouseover', function(fEvent) {
			//alert('enter');
			var NumVal = fEvent.row['C_Name'].value;
			if (NumVal  == '臺北市')
			{
				layer2.setOptions({
					styles: [{
						where: "'C_Name' = '臺北市'" , 
						polygonOptions: {
							//fillColor: "#0000FF",
							fillOpacity: 0.3
						}
					}]
				});
			}
			
		});
		
		  //here's the pseudo-hover
		google.maps.event.addListener(layer2, 'mouseout', function(fEvent) {
			//alert('enter');
			var NumVal = fEvent.row['C_Name'].value;
			//alert(NumVal);
			//if (NumVal  == '臺北市')
			//{
				layer2.setOptions({
					styles: [{
						where: "'C_Name' = '臺北市'" , 
						polygonOptions: {
							//fillColor: "#0000FF",
							fillOpacity: 1.0
						}
					}]
				});
			//}
			
		});
		
		
	
		google.maps.event.addListener(layer2, 'click', function(event) {
			zoommap(event);	  
		});
		*/
		
		// google.maps.event.addListener(layer, "click", drawMap);
		
		 // layer2.setMap(map);
		  
  
/*FusionTable for non api key usage End*/

/*FusionTable for api key usage Start*/
   // Initialize JSONP request
        var script = document.createElement('script');
        var url = ['https://www.googleapis.com/fusiontables/v1/query?'];
        url.push('sql=');
        var query = 'SELECT * FROM ' +
            '1luO9T2YvyPwp3GLRtLZjUr9FlV3Bt0pC7Ojv8iX_';
        var encodedQuery = encodeURIComponent(query);
        url.push(encodedQuery);
        url.push('&callback=drawMap');
        url.push('&key=AIzaSyCIv1oNVKD5Eoz8zctBZpaVJJIch4Nub7Q');
        script.src = url.join('');
        var body = document.getElementsByTagName('body')[0];
        body.appendChild(script);
  /*FusionTable for api key usage End*/
 
  
  /*google.maps.event.addListener(bermudaTriangle, 'click', showArrays);

  var triangleCoords = [
      new google.maps.LatLng(25.019351, 121.492310),
      new google.maps.LatLng(24.961471, 121.559258),
      new google.maps.LatLng(25.046414, 121.619339),
	  new google.maps.LatLng(25.114202, 121.539001)
  ];

  // Construct the polygon.
  bermudaTriangle = new google.maps.Polygon({
    paths: triangleCoords,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 3,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  });
  
  bermudaTriangle.setMap(map);
  

  // Add a listener for the click event.
  google.maps.event.addListener(bermudaTriangle, 'click', showArrays);*/
 /* 
   infoWindow = new google.maps.InfoWindow();

	alert( locations.length);
    for (i = 0; i < locations.length; i++) {
      /*marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]+'<br>');
          infowindow.open(map, marker);
        }
      })(marker, i));
	  


    }
	*/


	/** @this {google.maps.Polygon} */

	function addmarker(loca,addr)
	{
		//alert("enter addmarker");
		   //alert(loca.lat());
		   //alert(loca.lng());
		   //alert(addr);

		infoWindow = new google.maps.InfoWindow();

		marker = new google.maps.Marker({
        		position: new google.maps.LatLng(loca.lat(), loca.lng()),
			map: map
		});

	google.maps.event.addListener(marker, 'click', (function(marker) {
				return function() {
				infowindow.setContent(addr+'<br>');
				infowindow.open(map, marker);
				}
				})(marker));

	}

//function showArrays(event) {

  //// Since this polygon has only one path, we can call getPath()
  //// to return the MVCArray of LatLngs.
  //var vertices = this.getPath();

  //var contentString = '<b>Bermuda Triangle polygon</b><br>' +
      //'Clicked location: <br>' + event.latLng.lat() + ',' + event.latLng.lng() +
      //'<br>';

  //// Iterate over the vertices.
  //for (var i =0; i < vertices.getLength(); i++) {
    //var xy = vertices.getAt(i);
    //contentString += '<br>' + 'Coordinate ' + i + ':<br>' + xy.lat() + ',' +
        //xy.lng();
  //}

  //// Replace the info window's content and position.
  //infoWindow.setContent(contentString);
  //infoWindow.setPosition(event.latLng);

  //infoWindow.open(map);
  
  ////在V3的版本請改用此物件
	//var bounds = new google.maps.LatLngBounds();
	// 
	//for (var i = 0; i < vertices.getLength(); i++) {
	//    //在API中說到extend【延伸此界限以包含指定的點】，這個意思是加入多個座標
	 	//var xy = vertices.getAt(i);
	//    bounds.extend(new google.maps.LatLng(xy.lat(), xy.lng()));
	//}
	////重新設定Zoom Size
	//map.fitBounds(bounds);

  
//}


/* Address translate to lat lng callback function Start*/

  	function getlandone()
  	{

		//alert("done");
		   //alert(g_loc.lat());
		   //alert(g_loc.lng());
		   //alert(g_address);


		addmarker(g_loc , g_address);

		//alert(markers.length);
		//addmarker
	}
/* Address translate to lat lng callback function End*/


  /*
  	Translate map from address to lat , lng
  */
  ////////////////////////////
  function getlanlng(address,callback)
  {
		//alert("test");
  		geocoder = new google.maps.Geocoder();
		geocoder.geocode(
	  {
		 'address':address //此處帶入Request屬性
	  },function (results,status) 
	  {
		 if(status==google.maps.GeocoderStatus.OK) 
		 {
		  g_address = address;
		   g_loc = results[0].geometry.location;
		   //alert(g_loc.lat());
		   //alert(g_loc.lng());
		   //markers.push({
			//title: addr,
			//latlng: new google.maps.LatLng(loc.lat(), loc.lng())
			//});

		callback();//alert once when finish one data

		 }


	  }
	); 

  }


		/*
       * Open the info window
       */

	function fusionclick0(country,event) {
		
		// If we use Bounds for zoomin each country, seems like a issue here.
		// use zoom in click center replace it.
		/*
		var vertices =  country.getPath();
		var bounds = new google.maps.LatLngBounds();
		 
		for (var j = 0; j < vertices.getLength(); j++) {
		    //在API中說到extend【延伸此界限以包含指定的點】，這個意思是加入多個座標
			var xy = vertices.getAt(j);
		    bounds.extend(new google.maps.LatLng(xy.lat(), xy.lng()));
		}
		//重新設定Zoom Size
		map.fitBounds(bounds);*/
		
		alert('Clicked location: <br>' + event.latLng.lat() + ',' + event.latLng.lng());
		map.setZoom(10);
  		map.setCenter(new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()));
	}

	function zoommap(event)
	{

		
		/*var bounds = new google.maps.LatLngBounds();
		 
		for (var j = 0; j < vertices.getLength(); j++) {
		    //在API中說到extend【延伸此界限以包含指定的點】，這個意思是加入多個座標
			var xy = vertices.getAt(j);
		    bounds.extend(new google.maps.LatLng(xy.lat(), xy.lng()));
		}
		//重新設定Zoom Size
		map.fitBounds(bounds);
		*/
		alert('Clicked location: <br>' + event.latLng.lat() + ',' + event.latLng.lng());
		map.setZoom(9);
  		map.setCenter(new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()));
		
		
	}

	  function drawMap(data) {
        var rows = data['rows'];

		var country = [];
        for (var i in rows) {

            var newCoordinates = [];
            var geometries = rows[i][6]['geometries'];
            if (geometries) {
              for (var j in geometries) {
                newCoordinates.push(constructNewCoordinates(geometries[j]));
              }
            } else {
              newCoordinates = constructNewCoordinates(rows[i][6]['geometry']);
            }
            var randomnumber = Math.floor(Math.random() * 4);
            country[i] = new google.maps.Polygon({
              paths: newCoordinates,
              strokeColor: colors[randomnumber],
              strokeOpacity: 0,
              strokeWeight: 1,
              fillColor: colors[randomnumber],
              fillOpacity: 0.3
            });
            google.maps.event.addListener(country[i], 'mouseover', function() {
              this.setOptions({fillOpacity: 1});
            });
            google.maps.event.addListener(country[i], 'mouseout', function() {
              this.setOptions({fillOpacity: 0.3});
            });
			//alert(i);
			switch (i) {
				case "0":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[0],event);	  
					});
					break;
				case "1":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[1],event);	  
					});
					break;
				case "2":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[2],event);	  
					});
					break;
				case "3":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[3],event);	  
					});
					break;
				case "4":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[4],event);	  
					});
					break;
				case "5":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[5],event);	  
					});
					break;
				case "6":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[6],event);	  
					});
					break;
				case "7":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[7],event);	  
					});
					break;
				case "8":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[8],event);	  
					});
					break;
				case "9":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[9],event);	  
					});
					break;
				case "10":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[10],event);	  
					});
					break;
				case "11":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[11],event);	  
					});
					break;
				case "12":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[12],event);	  
					});
					break;
				case "13":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[13],event);	  
					});
					break;
				case "14":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[14],event);	  
					});
					break;
				case "15":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[15],event);	  
					});
					break;
				case "16":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[16],event);	  
					});
					break;
				case "17":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[17],event);	  
					});
					break;
				case "18":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[18],event);	  
					});
					break;
				case "19":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[19],event);	  
					});
					break;
				case "20":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[20],event);	  
					});
					break;
				case "21":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[21],event);	  
					});
					break;
				case "22":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[22],event);	  
					});
					break;
				case "23":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[23],event);	  
					});
					break;
				case "24":
					google.maps.event.addListener(country[i], 'click', function(event) {
                            fusionclick0(country[24],event);	  
					});
					break;
			}
            country[i].setMap(map);
          }
	}
	function constructNewCoordinates(polygon) {
        var newCoordinates = [];
        var coordinates = polygon['coordinates'][0];
        for (var i in coordinates) {
          newCoordinates.push(
              new google.maps.LatLng(coordinates[i][1], coordinates[i][0]));
        }
        return newCoordinates;
      }


 </script>
  <div class="article">
    <?php breadcrumb_init(); ?>
    <?php

			  $args_careagency = array(
				  'tag'		=> 'careagency',
				  'showposts'	=> 1
			  );
			// query
			$wp_query_args_careagency = new WP_Query( $args_careagency );

			  $args_caretech = array(
	  'tag'		=> 'caretech',
	  'showposts'	=> 1
  );
// query
$wp_query_args_caretech = new WP_Query( $args_caretech );

			  $args_carearticle = array(
	  'tag'		=> 'carearticle',
	  'showposts'	=> 1
  );
// query
$wp_query_args_carearticle = new WP_Query( $args_carearticle );

		?>
    <?php while ( $wp_query_args_careagency->have_posts() ) : $wp_query_args_careagency->the_post(); ?>
    <article class="article-content">
      <h1>最新長照機構</h1>
      <div class=contentshow >
        <h2 class="article-title">
          <?php the_title(); ?>
        </h2>
        <?php the_content(); ?>
      </div>
      <div class="clearfix"></div>
    </article>
    <?php endwhile; ?>
    <?php while ( $wp_query_args_caretech->have_posts() ) : $wp_query_args_caretech->the_post(); ?>
    <article class="article-content">
      <h1>照顧技巧新知</h1>
      <div class=contentshow >
        <h2 class="article-title">
          <?php the_title(); ?>
        </h2>
        <?php the_content(); ?>
      </div>
      <div class="clearfix"></div>
    </article>
    <?php endwhile; ?>
    <?php while ( $wp_query_args_carearticle->have_posts() ) : $wp_query_args_carearticle->the_post(); ?>
    <article class="article-content">
      <h1>長照專欄分享</h1>
      <div class=contentshow >
        <h2 class="article-title">
          <?php the_title(); ?>
        </h2>
        <?php the_content(); ?>
      </div>
      <div class="clearfix"></div>
    </article>
    <?php endwhile; ?>
  </div>
</div>
<body>
</body>
<?php get_footer(); ?>
