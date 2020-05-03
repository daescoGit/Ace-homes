<?php
session_start();
if(!$_SESSION){header('Location: login.php');}
$sProfileId = $_SESSION['sProfileId'];

if($_POST){
$sUniquePropertyId = bin2hex(random_bytes(10));
$sImgName = $_FILES['propertyImg']['name'];
move_uploaded_file($_FILES['propertyImg']['tmp_name'], __DIR__."/images/$sImgName");

$jProperty = new stdClass();
$jProperty->id = $sUniquePropertyId;
$jProperty->geometry->coordinates = [floatVal($_POST['txtCoordinates2']),floatVal($_POST['txtCoordinates1'])];
$jProperty->geometry->type = "Point";
$jProperty->properties->iconSize = [20,20];
$jProperty->properties->message = "Foo";
$jProperty->type = "Feature";
$jProperty->image = 'images/'.$sImgName;
$jProperty->price = $_POST['txtPrice'];
$jProperty->bds = $_POST['txtBds'];
$jProperty->ba = $_POST['txtBa'];
$jProperty->m2 = $_POST['txtM2'];
$jProperty->zip = $_POST['txtZip'];
$jProperty->seller = $sProfileId;
$jProperty->address = $_POST['txtAddress'];
$jProperty->city = $_POST['txtCity'];

//echo json_encode($jProperty);

$sjProperties = file_get_contents(__DIR__. '/properties.json');
$jProperties = json_decode($sjProperties);
//echo json_encode($jProperties[0]->id);
array_push($jProperties,$jProperty);
//$jProperties[0]->$sUniquePropertyId = $jProperty;
//echo json_encode($jProperties->id);

$sjProperties = json_encode($jProperties, JSON_PRETTY_PRINT);
file_put_contents(__DIR__.'/properties.json', $sjProperties);
}
header('Location: profile.php');
?>