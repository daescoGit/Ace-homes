<?php
$sPropertyId = $_POST['id'];
$sKeyToUpdate = $_POST['key'];
$sNewValue = $_POST['value'];

if($sKeyToUpdate == 'price'){intVerify($sNewValue, 10);}
if($sKeyToUpdate == 'bds' || $sKeyToUpdate == 'ba'){intVerify($sNewValue, 3);}
if($sKeyToUpdate == 'm2'){intVerify($sNewValue, 5);}
if($sKeyToUpdate == 'zip'){intVerify($sNewValue, 4);    if(strlen($sNewValue) < 4){echo 0;exit;}}
if($sKeyToUpdate == 'address'){strVerify($sNewValue, 40);}
if($sKeyToUpdate == 'city'){strVerify($sNewValue, 20);}

function intVerify($sNewValue, $maxLen){
    if(empty($sNewValue)){
        echo 0;
        exit;
    }
    if(!ctype_digit($sNewValue)){
        echo 0;
        exit;
    }
    if(strlen($sNewValue) > $maxLen){
        echo 0;
        exit;    
    }
}
function strVerify($sNewValue, $maxLen){
    if(empty($sNewValue)){
        echo 0;
        exit;
    }
    /* if(!ctype_alnum($sNewValue)){ fix later
        echo 0;
        exit;
    } */
    if(strlen($sNewValue) > $maxLen){
        echo 0;
        exit;    
    }
}

$sjProperties = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/ace/properties.json'); 
$jProperties = json_decode($sjProperties);

//$jProperties->$sProfileType->$sProfileId->$sKeyToUpdate = $sNewValue;

 foreach($jProperties as $jProperty){
    if($jProperty->id == $sPropertyId){
    $jProperty->$sKeyToUpdate = $sNewValue;
    //echo $sKeyToUpdate;
    }
}

$sjProperties = json_encode($jProperties, JSON_PRETTY_PRINT);
file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/ace/properties.json', $sjProperties);
echo 1; 