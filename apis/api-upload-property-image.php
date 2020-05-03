<?php
$sFileName = $_FILES['imgFile']['name'];
$sPropertyId = $_POST['propertyId'];
$location = $_SERVER['DOCUMENT_ROOT'] . '/ace/images/' .$sFileName;
$sExtension = pathinfo($location,PATHINFO_EXTENSION);
$sAllowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];

if(empty($_FILES['imgFile'])){
   echo 1; //.'Image is missing';
   exit;
}       
if(!in_array(strtolower($sExtension), $sAllowedExtensions)){
   echo 2;// .'The uploaded file is not a valid image file. It must be jpg / jpeg / png / gif';
   exit;
}
if($_FILES['imgFile']['size'] < 5120){ // in bytes (5 kilo byte)
   echo 3;// .'The uploaded file is too small';
   exit;
}
if($_FILES['imgFile']['size'] > 15360000){ // in bytes (15 mega byte)
   echo 4;// .'The uploaded file is too large';
   exit;
}

if(move_uploaded_file($_FILES['imgFile']['tmp_name'],$location)){
   $sjProperties = file_get_contents(__DIR__.'/../properties.json'); 
   $jProperties = json_decode($sjProperties);

   //$jProperties->$sProfileId->image = 'images/'.$sFileName;
   foreach($jProperties as $jProperty){
      if($jProperty->id == $sPropertyId){
         echo $sPropertyId;
      //$jProperty->image = 'images/'.$sFileName;
      //echo $sKeyToUpdate;
      }
   }

   /*$sjProperties = json_encode($jProperties, JSON_PRETTY_PRINT);
   file_put_contents(__DIR__.'/../properties.json', $sjProperties);
   //echo $location; // $filename mb
   echo 'images/'.$sFileName;*/
}