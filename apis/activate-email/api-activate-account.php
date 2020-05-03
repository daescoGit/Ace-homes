<?php
ini_set( "display_errors", 0); // fix this notice later
// defensive coding first here:
// check user id is passed
// check id is valid syntax/pattern (eg. 'U'...)
// check that the key is valid syntax/pattern
$sKey = $_GET['key']; 
$sUserId = $_GET['id'];

$sjData = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/ace/profiles.json'); 
$jData = json_decode( $sjData );

 if($jData->users->$sUserId->verified == 1 || $jData->agents->$sUserId->verified == 1){
  echo 'This account has already been activated';
  exit; // vigtigt da næste if statement kan stadig være true
}

if($jData->users->$sUserId->activationKey == $sKey){
  echo 'Your account is now active';
  $jData->users->$sUserId->verified = 1; 
  $sjData = json_encode( $jData, JSON_PRETTY_PRINT );
  file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/ace/profiles.json' , $sjData);
  exit;
}
if($jData->agents->$sUserId->activationKey == $sKey){
  echo 'Your account is now active';
  $jData->agents->$sUserId->verified = 1; 
  $sjData = json_encode( $jData, JSON_PRETTY_PRINT );
  file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/ace/profiles.json' , $sjData);
}else{
  echo 'No match found, please contact customer service to resolve this issue';
}