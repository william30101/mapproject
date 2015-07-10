<?php
/*
Template Name: MAPSearch
*/
get_header();
?>
<h1>
  <?php the_title(); 
  $bedshow=false;?>

<?php
  // Nav Menu Dropdown Class
include_once( get_template_directory()  . '/lib/classes/nav-menu-dropdown.php' );
?>

</h1>
<div class="content">
    <div class="mapside">
          <div id="map" style="width: 400px; height: 600px; " class="maplocation" ></div>
          <div id="findborder" style="margin-top: 10px;">
                  <label class="layer-wizard-search-label">
                    <div class="priceOption">價格 : </div>
                    
                    <?php
					wp_nav_menu( array(
							// 'theme_location' => 'mobile',
							'menu'           => 'priceOption',
							'walker'         => new Walker_Nav_Menu_Dropdown(),
							'items_wrap'     => '<div class="mobile-menu"><form><select id="search-price">%3$s</select></form></div>',
					) );
					?>
                    <!--
                     <select name="search-price">
                            　<option value="0">不限</option>
                            　<option value="1">三萬以下</option>
                            　<option value="2">三萬-四萬</option>
                            　<option value="3">四萬以上</option>
                        </select>-->
                        <br>
                        <div style="clear:both"></div>
                    <div class="classOption">類別 :</div>
                    <?php
					wp_nav_menu( array(
							// 'theme_location' => 'mobile',
							'menu'           => 'careoption',
							'walker'         => new Walker_Nav_Menu_Dropdown(),
							'items_wrap'     => '<div class="mobile-menu"><form><select id="search-care">%3$s</select></form></div>',
					) );
					?>
                   <!-- <select name="search-class">
                        　<option value="care">護理</option>
                        　<option value="longCare">長照</option>
                        　<option value="maintenance">養護</option>
                        　<option value="rescue">安養</option>
                        　<option value="sunshine">日照</option>
                    </select>-->
                    <br>
                    <?php if ($bedshow) echo "空床 : "?> <input type="checkbox" id="search-havebed" hidden="true"><br>
                    <button class="btnhvr" onClick="searchMarker()">Search</button>
                  </label> 
            </div>
        </div>
  	
  
  <?php
  $args = array(
	  'post_type' => 'post',
	  'posts_per_page'	=> -1
  );
// query
$wp_query = new WP_Query( $args );
$NUM = 0;

?>
  <script type="text/javascript">

/* Improve user address add marker start*/
	var g_loc;
	var g_address;
	var g_backupCountry;
	var g_town = [];
	var g_townName = [];
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
   
   
	//var countryColors = ['#FF0000', '#00FF00', '#0000FF', '#FFFF00'];
	//var townColors = ['#FF0000', '#00FF00', '#0000FF', '#FFFF00'];
    var map = new google.maps.Map(document.getElementById('map'), { 
      zoom: 8, /*Here you change zoom for your map*/
      center: new google.maps.LatLng(23.802140, 121.004623), /*Here you change center map first location*/
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();
	var townInfoWindow = new google.maps.InfoWindow();
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
   //https://www.googleapis.com/fusiontables/v2/tables/1luO9T2YvyPwp3GLRtLZjUr9FlV3Bt0pC7Ojv8iX_/columns?key=AIzaSyCIv1oNVKD5Eoz8zctBZpaVJJIch4Nub7Q&fields=kind,items(name)
        var script = document.createElement('script');
        var url = ['https://www.googleapis.com/fusiontables/v2/query?'];
		
        url.push('sql=');
        var query = 'SELECT county , geometry FROM ' +
            '1KUe25wKNhJZdGLJMz5Xc_EEGtK0lTh0OTu-K93qa';

		
        var encodedQuery = encodeURIComponent(query);
        url.push(encodedQuery);
 		url.push('&callback=drawMap');
        url.push('&key=AIzaSyCIv1oNVKD5Eoz8zctBZpaVJJIch4Nub7Q');
		
		//url.push('&fields=kind,items(name)');
        script.src = url.join('');
        var body = document.getElementsByTagName('body')[0];
        body.appendChild(script);
  /*FusionTable for api key usage End*/


	function searchMarker() {
      var whereClause;
      var searchString = document.getElementById('search-care').value.replace(/'/g, "\\'");
	  
	  // We find last slash char , substring we need tag.
	  // ex : http://localhost/wordpress/category/rescue/
	  // only need rescue this tag for codeing.
	  
	  var tagIndex = searchString.lastIndexOf('/',searchString.length-2 );
	  tagIndex = tagIndex + 1; // We don't need '/'rescue this slash.
	  var tagName = searchString.substring(tagIndex,searchString.length-1);
	  //alert(searchString+'  /index=' + tagIndex);
	 // alert(tagName);
	  
      /*if (searchString != '--Select--') {
        whereClause = "'county' CONTAINS IGNORING CASE '" + searchString + "'";
      }
	  layer_0 = new google.maps.FusionTablesLayer({
    		query: {
          		select: "col6",
          		from: "1KUe25wKNhJZdGLJMz5Xc_EEGtK0lTh0OTu-K93qa",
          		where: whereClause
        	}
  		});
	  
	  
	  layer_0.setMap(map);*/
    }


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

/* Address translate to lat lng callback function Start*/

  	function getlandone()
  	{
		addmarker(g_loc , g_address);
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

			callback();//alert once when finish one data
		 }
	  }
	); 

  }

	function getRandomColor() {
		var letters = '0123456789ABCDEF'.split('');
		var color = '#';
		for (var i = 0; i < 6; i++ ) {
			color += letters[Math.floor(Math.random() * 16)];
		}
		return color;
	}
		/*
       * Open the info window
       */

	function countryClick(country,countryName) {
		return function(event){
			
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
	
			//alert('Clicked location: <br>' + event.latLng.lat() + ',' + event.latLng.lng() + ', ' +countryName );
			map.setZoom(11);
			map.setCenter(new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()));
			
			
			// If we change click country from 桃園市 to 台北市
			// We need to recovery previous Polygon; 
			if (g_backupCountry != null)
			{
				g_backupCountry.setMap(map);
				country_layer.setMap(null);
			}
			
			//alert('length = ' + g_town.length);
			if (g_town.length > 0 )
			{
				for (var i = 0; i < g_town.length ; i++) {
					g_town[i].setMap(null);
				}
			}
			
			g_backupCountry = country;
			country.setMap(null);
	
			drawcountry(countryName);
		  
			//layer3.setMap(map);
		}
	}
	
	 function drawcountry(clickCountry) {
		 //alert(clickCountry);
		 
      var whereClause;
      //var searchString = document.getElementById('search-string_0').value.replace(/'/g, "\\'");
	  searchString = clickCountry;
	  
	  whereClause = "'county' CONTAINS IGNORING CASE '" + searchString + "'";
	  
	   country_layer = new google.maps.FusionTablesLayer({
        query: {
          select: "col9",
          from: "1L3alBICY7wKsbqwrPQokq5jm-Gsw71RReiFzl8HC",
		  where: whereClause
        },
		styles: [{
      polygonOptions: {
		strokeColor: '#FF0000',
		strokeOpacity: 0,
		strokeWeight: 5,
      }
    }],
        map: map
        //styleId: 2,
        //templateId: 2
      });

   		var script2 = document.createElement('script');

        var url = ['https://www.googleapis.com/fusiontables/v2/query?'];
		
        url.push('sql=');
        var query = "SELECT town,geometry FROM " +
            '1L3alBICY7wKsbqwrPQokq5jm-Gsw71RReiFzl8HC' + " WHERE 'county' CONTAINS IGNORING CASE '" + searchString + "'";

		
        var encodedQuery = encodeURIComponent(query);
        url.push(encodedQuery);
 		url.push('&callback=drawTownMap');
        url.push('&key=AIzaSyCIv1oNVKD5Eoz8zctBZpaVJJIch4Nub7Q');
		
		//url.push('&fields=kind,items(name)');
        script2.src = url.join('');
        var body = document.getElementsByTagName('body')[0];
        body.appendChild(script2);
 
	  
    }

		// we get count row number , 12 = 0-12
		function drawTownMap(data) {
			var rows = data['rows'];
			
			for (var i in rows) {
				g_townName[i] = rows[i][0];
				//alert(VilleageName);
            	var newCoordinates = [];
            	var geometries = rows[i][1]['geometries'];
				
            if (geometries) {
              for (var j in geometries) {
                newCoordinates.push(constructNewCoordinates(geometries[j]));
              }
            } else {
              newCoordinates = constructNewCoordinates(rows[i][1]['geometry']);
            }
            var randomColor = getRandomColor();
            g_town[i] = new google.maps.Polygon({
              paths: newCoordinates,
              strokeColor: randomColor,
              strokeOpacity: 0,
              strokeWeight: 5,
              fillColor: randomColor,
              fillOpacity: 0.3
            });
           // google.maps.event.addListener(g_town[i], 'mouseover', function() {
           //   this.setOptions({fillOpacity: 1});
           // });
		    google.maps.event.addListener(g_town[i], 'mouseover', townHover(i));
            /*
			google.maps.event.addListener(g_town[i], 'mouseout', function() {
              this.setOptions({fillOpacity: 0.3});
            });
			*/
			google.maps.event.addListener(g_town[i], 'click', townClick(i));

			g_town[i].setMap(map);
			
			}
		}
		
	  function townHover(count){
			return function(event){
				//alert(event.latLng.lat()  + ' , ' + event.latLng.lng() );
				
				townInfoWindow.setContent(g_townName[count]+'<br>');
				townInfoWindow.setPosition(new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()));

				townInfoWindow.open(map);
			}
	   }
	   
	   /*
	   		redirect to search page when user click each town.
	   */
	   function townClick(count){
			return function(event){
				<?php $url = network_home_url();?>
				window.location = "<?php echo $url.'/searchlongcare'; ?>";
			}
	   }
	   
		
	  function drawMap(data) {
        var rows = data['rows'];
		var countryName = [];
		var country = [];
        for (var i in rows) {
			countryName[i] = rows[i][0];
			//alert(VilleageName);
            var newCoordinates = [];
            var geometries = rows[i][1]['geometries'];
            if (geometries) {
              for (var j in geometries) {
                newCoordinates.push(constructNewCoordinates(geometries[j]));
              }
            } else {
              newCoordinates = constructNewCoordinates(rows[i][1]['geometry']);
            }
            //var randomnumber = Math.floor(Math.random() * 4);
			var randomColor = getRandomColor();
            country[i] = new google.maps.Polygon({
              paths: newCoordinates,
              strokeColor: randomColor,
              strokeOpacity: 0,
              strokeWeight: 1,
              fillColor: randomColor,
              fillOpacity: 0.3
            });
            google.maps.event.addListener(country[i], 'mouseover', function() {
              this.setOptions({fillOpacity: 1});
            });
            google.maps.event.addListener(country[i], 'mouseout', function() {
              this.setOptions({fillOpacity: 0.3});
            });
			
			google.maps.event.addListener(country[i], 'click', countryClick(country[i],countryName[i]));
			
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
