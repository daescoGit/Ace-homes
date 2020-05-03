<?php
$sProfileId = $_POST['id'];
$sKeyToUpdate = $_POST['key'];
$sNewValue = $_POST['value'];
$sProfileType =  $_POST['type'];

if($sKeyToUpdate == 'email'){
    if(empty($sNewValue)){
    echo 0;
    exit;
    }
    if(!filter_var($sNewValue, FILTER_VALIDATE_EMAIL)){
    echo 0;
    exit;
    }
}
if($sKeyToUpdate == 'firstname' || $sKeyToUpdate == 'lastname'){
    if(empty($sNewValue)){
    echo 0;
    exit;
    }
    if(!ctype_alpha($sNewValue)){
    echo 0;
    exit;
    }
    if(strlen($sNewValue) < 2 || strlen($sNewValue) > 40){
    echo 0;
    exit;    
    }
}
if($sKeyToUpdate == 'zip'){
    if(strlen($sNewValue) != 0){
        if(!ctype_digit($sNewValue)){
        echo 0;
        exit;
        }
        if(strlen($sNewValue) < 4 || strlen($sNewValue) > 4){
        echo 0;
        exit;    
        }
    }
}
if($sKeyToUpdate == 'phone'){
    if(strlen($sNewValue) != 0){
        if(!ctype_digit($sNewValue)){
        echo 0;
        exit;
        }
        if(strlen($sNewValue) < 6 || strlen($sNewValue) > 10){
        echo 0;
        exit;    
        }
    }
}

$sjData = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/ace/profiles.json'); 
$jData = json_decode($sjData);

$jData->$sProfileType->$sProfileId->$sKeyToUpdate = $sNewValue;

$sjData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/ace/profiles.json', $sjData);
echo 1; 