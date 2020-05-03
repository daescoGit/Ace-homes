<?php
session_start();
if(!$_SESSION){
header('Location:login.php');
//echo 'No profile currently in session';
}
$sProfileId = $_SESSION['sProfileId'];
$sPropertyId = $_GET['id'];

$sjProperties = file_get_contents(__DIR__ .'/properties.json');
$jProperties = json_decode($sjProperties);

foreach($jProperties as &$jProperty){ //&$jProperty
    if($sPropertyId == $jProperty->id && $sProfileId == $jProperty->seller){
    //unset($jProperty);
    //$GLOBALS['jProperty'];
    $jProperty = 'empty_property';
}
}
$delete = array_search('empty_property', $jProperties);
array_splice($jProperties, $delete, 1);

//unset($jProperties[$delete]); // adds obj names for some reason
//echo json_encode($jProperties);
//echo json_encode($jProperties[9]);

//$sjProperties = json_encode($jProperties, JSON_PRETTY_PRINT);
//file_put_contents(__DIR__.'/properties.json', $sjProperties);

//echo json_encode($jProperties->empty);

//unset($jProperty);
//echo json_encode($jProperties[0]);

$sjProperties = json_encode($jProperties, JSON_PRETTY_PRINT);
file_put_contents(__DIR__.'/properties.json', $sjProperties);
header('Location: profile.php');
?>