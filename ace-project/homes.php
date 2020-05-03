<?php
$pageTitle = 'Homes';
require_once(__DIR__.'/components/top.php');
//error_reporting(E_ERROR | E_PARSE);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<div class="homesContainer">
  <div id="mapWrap">
  <form action="homes.php" style="width: auto;">
  <div id="search"><input name="category" id="txtSearch" type="text" placeholder="Enter an address, city or zipcode" autocomplete="off" style="">
  </form>
  <div id="results"></div></div>
  <div id="map"></div>
  </div>
  <div id="propertiesWrap">
  <div id="propertiesInfo"><h1>Properties</h1><b><?php if($_GET){echo 'Showing results for search: '.$_GET['category'];}else{echo 'Showing all homes';}?></b><b><?php if(!empty($_GET) || !empty($_GET['category'])){echo '<a href="homes.php" style="font-size: 90%;">SHOW ALL</a>';}?></b></div>
  <div id="properties">
  <?php
    $sjProperties = file_get_contents('properties.json');
    $jProperties = json_decode( $sjProperties );
    $sjProfiles = file_get_contents('profiles.json');
    $jProfiles = json_decode($sjProfiles);
    foreach( $jProperties as $jProperty){
      if(empty($_GET) || empty($_GET['category'])){
        echo '<div id="Right'.$jProperty->id.'" class="property">
          <img src="'.$jProperty->image.'">
          <div class="propertyInfo">
          <div class="propertyTopInfo">
            <div class="price">£'.$jProperty->price.'</div>
            <div class="rooms">'.$jProperty->bds.' bds | '.$jProperty->ba.' ba | '.$jProperty->m2.' m&#178;</div>
          </div>
            <div class="propertyBottomInfo">
              <div><b>Address:</b></div><div id="homePropText">'.$jProperty->address.'</div>
              <div><b>City:</b></div><div id="homePropText">'.$jProperty->city.'</div>
              <div><b>Zip Code:</b></div><div id="homePropText">'.$jProperty->zip.'</div>
              <div><b>Agent:</b></div><div id="homePropText">';foreach($jProfiles->agents as $sKey => $jAgent){if($sKey == $jProperty->seller){echo ' '.$jAgent->firstname.' '.$jAgent->lastname;}}
              echo '</div>             
            </div>
          </div>
          <div class="propertyBottomLine"></div>
        </div>';
      }
      else if($jProperty->zip == $_GET['category'] || $jProperty->address == $_GET['category'] || $jProperty->city == $_GET['category']){
        echo '<div id="Right'.$jProperty->id.'" class="property">
          <img src="'.$jProperty->image.'">
          <div class="propertyInfo">
          <div class="propertyTopInfo">
            <div class="price">£'.$jProperty->price.'</div>
            <div class="rooms">'.$jProperty->bds.' bds | '.$jProperty->ba.' ba | '.$jProperty->m2.' m&#178;</div>
          </div>
            <div class="propertyBottomInfo">
              <div><b>Address:</b></div><div id="homePropText">'.$jProperty->address.'</div>
              <div><b>City:</b></div><div id="homePropText">'.$jProperty->city.'</div>
              <div><b>Zip Code:</b></div><div id="homePropText">'.$jProperty->zip.'</div>
              <div><b>Agent:</b></div><div id="homePropText">';foreach($jProfiles->agents as $sKey => $jAgent){if($sKey == $jProperty->seller){echo ' '.$jAgent->firstname.' '.$jAgent->lastname;}}
              echo '</div>             
            </div>
          </div>
          <div class="propertyBottomLine"></div>
        </div>';
        }
    }
    ?>
  </div>
</div>

<!-- map -->
<script>
      const sjProperties = '<?php echo json_encode($jProperties); ?>'
      ajProperties = JSON.parse(sjProperties) // convert text into an object
      console.log(ajProperties)

      mapboxgl.accessToken = 'pk.eyJ1Ijoic2FudGlhZ29kb25vc28iLCJhIjoiY2swYzVoYmNmMHlkZzNibzR4NTNxamU3cSJ9.QNJx-cfl48aSOx8purGNeA';
      var map = new mapboxgl.Map({
      container: 'map',
      center: [12.5204696, 55.6832036], // starting position
      zoom: 11, // starting zoom
      style: 'mapbox://styles/santiagodonoso/ck0c6jrhh02va1cnp07nfsv64'
      
      });
      map.addControl(new mapboxgl.NavigationControl());

    // JSON works with for in loops
    // Arrays work with forEach and also with for of
      for( let jProperty of ajProperties ){ // json object with json objects in it
      // code for query string
      var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName, i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
      };
      //
      var el = document.createElement('a');
      el.href = '#Right'+jProperty.id
      el.className = 'marker'
      el.style.backgroundImage = 'url(images/marker3.png)';
      el.style.width = "30px"
      el.style.height = "29px"
      el.id = jProperty.id
      el.addEventListener('click', function() {
        console.log(`Highlight property with ID ${this.id} `);
        removeActiveClassFromProperty()
        document.getElementById(this.id).classList.add('activeHome') // left
        document.getElementById('Right'+this.id).classList.add('activeHome') // right
      });
    if(getUrlParameter('') || getUrlParameter('category') == ''){
    new mapboxgl.Marker(el).setLngLat(jProperty.geometry.coordinates).addTo(map);  
    }else if(jProperty.zip == getUrlParameter('category') || jProperty.address == getUrlParameter('category')  || jProperty.city == getUrlParameter('category')){
    new mapboxgl.Marker(el).setLngLat(jProperty.geometry.coordinates).addTo(map);  
    }    
  }

    // $('.active').removeClass('.active')
    function removeActiveClassFromProperty(){
      let properties = document.querySelectorAll('.activeHome')
      properties.forEach( function( oPropertyDiv ) {
        oPropertyDiv.classList.remove('activeHome')
      } )
    }  
</script>

<!-- search -->
<script>
  const txtSearch = document.querySelector('#txtSearch')
  const divResults = document.getElementById('results')
  txtSearch.addEventListener( 'input', function(){

    $.ajax({
      url : "apis/api-search.php",
      data : $('#txtSearch').serialize(),
      dataType: "JSON"
    }).done(function( matches ){
      $('#results').empty()
      $(matches).each( function( index , category ){ // jq foreach loop
          
          // /</g regex for alle <
          category = category.replace(/</g, '&lt;') // beskytter mod xxs injection
          category = category.replace(/>/g, '&gt;')
        let divcategory = `<div><a href="homes.php?category=${category}">${category}</a></div>`
        $('#results').append(divcategory)
      })
    }).fail( function(){
      // console.log('Error')
    })

    if( txtSearch.value.length == 0){
      divResults.style.display = 'none'
    }else{
      divResults.style.display = 'block'
    }
  })
</script>

</body>
</html>