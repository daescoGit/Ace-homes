<?php
$pageTitle = 'Ace Homes';
require_once(__DIR__.'/components/top.php');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<div id="houseBg"></div>
<div class="centerDiv" id="frontPageDiv">
<h1 class="ctaText"><span style="font-size:120%; font-family: 'Playfair Display';">F</span>ind <i style="color:#ff9640;">your</i> dream home today</h1>
<p class="ctaText2">Lets get started</p>
<form action="homes.php" style="width: auto;">
<div id="search"><input name="category" id="txtSearch" type="text" placeholder="Enter an address, city or zipcode" autocomplete="off" style="">
</form>
<div id="results"></div></div>

</div> 

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