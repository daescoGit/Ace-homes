<?php
$pageTitle = 'Profile';
session_start();
if(!$_SESSION){header('Location: login.php');}
require_once(__DIR__.'/components/top.php'); // session_start()

$sProfileId = $_SESSION['sProfileId'];

$sjProfiles = file_get_contents('profiles.json');
$jProfiles = json_decode($sjProfiles);

// todo: backend validation (+restrict access to right agent)
if(isset($jProfiles->agents->$sProfileId)){
    $jAgentId = $jProfiles->agents->$sProfileId;
    if($jAgentId->verified == 1){
        echo '
        <div id="mapBg"></div>
        <div class="contentBg" id="profileBg">
        <div class="contentContainer" id="profileContainer">
                <div class="centerDiv">
                <form action="uploading-property.php" method="POST" enctype="multipart/form-data" id="uploadPropertyForm">
                <label for="propertyImage" id="imgLabel"><img src="images/cozy-house2.jpg" alt="uploadImg" id="uploadImg"><p id="uploadImgTxt">UPLOAD IMAGE</p></label>
                <div><input name="propertyImg" type="file" data-type="image" id="propertyImage"></div>
                <div style="height: 20px;"></div><div><input name="txtPrice" type="text" data-type="integer" maxlength="10" data-max="10" minlength="1" data-min="1" placeholder="Price"></div>
                <div><input name="txtBds" type="text" data-type="integer" maxlength="3" data-max="3" minlength="1" data-min="1" placeholder="Bed rooms"></div>
                <div><input name="txtBa" type="text" data-type="integer" maxlength="3" data-max="3" minlength="1" data-min="1" placeholder="Bath rooms"></div>
                <div><input name="txtM2" type="text" data-type="integer" maxlength="5" data-max="5" minlength="1" data-min="1" placeholder="Meter&#178"></div>
                <div><input name="txtZip" type="text" data-type="integer" maxlength="4" data-max="4" minlength="4" data-min="4" placeholder="Zip code"></div>
                <div><input name="txtAddress" type="text" data-type="string" maxlength="40" data-max="40" minlength="5" data-min="5" placeholder="Address"></div>
                <div><input name="txtCity" type="text" data-type="string" maxlength="20" data-max="20" minlength="2" data-min="2" placeholder="City"></div>
                <div><a href="https://www.google.com/maps/@55.6537703,12.5431688,12.69z" target="new">Find coordinates here: (Values in url)</a></div>
                <div class="splitDiv"><input name="txtCoordinates1" type="text" data-type="string" maxlength="20" data-max="20" minlength="1" data-min="1" placeholder="Ex: 55.6537703"><input name="txtCoordinates2" type="text" data-type="string" maxlength="20" data-max="20" minlength="5" data-min="5" placeholder="Ex: 12.5431688"></div>
                ';?><button onclick="return formValidate('#uploadPropertyForm')">Upload Property</button><?='
                </form>
                </div>
                <div class="centerDiv"><a href="profile.php">Back to profile</a></div>   
                </div>
                </div>
                ';
            }
            else{header('Location: login.php');}
        }
        
        ?>
<script src="validate.js"></script>
</body>
</html>