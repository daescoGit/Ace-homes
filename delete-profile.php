<?php
session_start();
if(!$_SESSION){
header('Location:login.php');
//echo 'No profile currently in session';
exit;
}
$sProfileId = $_SESSION['sProfileId'];
$sProfileType = $_GET['type'];

$sjData = file_get_contents(__DIR__ .'/profiles.json');
$jData = json_decode($sjData);

unset($jData->$sProfileType->$sProfileId);

$sjData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents(__DIR__.'/profiles.json', $sjData);
header('Location:logout.php'); // session_destroy
//echo 'Profile Deleted';
?>