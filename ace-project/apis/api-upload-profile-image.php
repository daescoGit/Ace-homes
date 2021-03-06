<?php
$sFileName = $_FILES['imgFile']['name'];
$sProfileType = $_POST['profileType'];
$sProfileId = $_POST['profileId'];
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
if($_FILES['imgFile']['size'] > 1024000){ // in bytes (1 mega byte)
   echo 4;// .'The uploaded file is too large';
   exit;
}

if(move_uploaded_file($_FILES['imgFile']['tmp_name'],$location)){
   $sjData = file_get_contents(__DIR__.'/../profiles.json'); 
   $jData = json_decode($sjData);

   $jData->$sProfileType->$sProfileId->image = 'images/'.$sFileName;

   $sjData = json_encode($jData, JSON_PRETTY_PRINT);
   file_put_contents(__DIR__.'/../profiles.json', $sjData);
   //echo $location;
   echo 'images/'.$sFileName;
}