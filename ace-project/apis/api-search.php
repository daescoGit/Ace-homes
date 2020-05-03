<?php
// header( 'Access-Control-Allow-Origin:*' );
if( !isset( $_GET['category'] ) ){
  echo '[]';
  exit;
}

$sSearchFor = $_GET['category']; // The user's input

$sjProperties = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/ace/properties.json'); 
$jProperties = json_decode($sjProperties);

$matches = [];

foreach($jProperties as $jProperty){
  $aZipCodes = [$jProperty->zip];
  $aAddress = [$jProperty->address];
  $aCity = [$jProperty->city];
  foreach( $aZipCodes as $sZipCode ){
    if( strpos( $sZipCode , $sSearchFor  ) !==  false ){ // check for match in db
      array_push( $matches , $sZipCode );
    }
  }
  foreach( $aAddress as $sAddress ){
    if( strpos( strtolower($sAddress) , strtolower($sSearchFor)  ) !==  false ){ 
      array_push( $matches , $sAddress );
    }
  }
  foreach( $aCity as $sCity ){
    if( strpos( strtolower($sCity) , strtolower($sSearchFor)  ) !==  false ){
      array_push( $matches , $sCity );
    }
  }
}


echo json_encode($matches);








// = =  1 is the same as "1" 
// = = = 1 is not the same as "1"
// Checking the data type

/*
$fruits = array("apple","orange","papaya","grape","apple juice", "applecurd");
$content = "ppl";
$content = str_split($content);
$count = count($content);

Foreach($fruits as $fruit){
    $arr_fruit = str_split($fruit);
    // sort $content to match order of $arr_fruit
    $SortCont = array_merge(array_intersect($arr_fruit, $content), array_diff($content, $arr_fruit));
    // if the first n characters match call it a match
    If(array_slice($SortCont, 0, $count) == array_slice($arr_fruit, 0, $count)){
        Echo "match: " . $fruit ."\n";
    }
}
*/






/*
if( in_array( $sSearchFor , $aZipCodes ) ){
  echo 'Match';
}else{
  echo 'Not found';
}
*/










