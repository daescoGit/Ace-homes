<?php 
session_start();
if(!$_SESSION){header('Location:login.php');} //skal være her online..(ryk js ned?/skaber underlig bug, fix senere)
//if($_SESSION){echo 'session igang ';}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="validate.js"></script>
<script src="update-profile.js"></script>
<?php
$pageTitle = 'Profile';
require_once(__DIR__.'/components/top.php'); // session_start()
//error_reporting(E_ERROR | E_PARSE);

$sProfileId = $_SESSION['sProfileId'];

$sjProfiles = file_get_contents('profiles.json');
$jProfiles = json_decode($sjProfiles);

if(isset($jProfiles->users->$sProfileId)){
    $jUserId = $jProfiles->users->$sProfileId;
    if($jUserId->verified != 1){
        echo '
        <div id="mapBg"></div>
        <div class="contentBg" id="profileBg">
            <div class="contentContainer" id="profileContainer">
                <div class="centerDiv"><p class="smallGtext">This account has not yet been activated, please check your email inbox for a verification link (Refresh this page or relog once verified)</p></div>
                <div class="centerDiv"></div>
                <div class="centerDiv"></div>
                <div class="centerDiv"><a href="logout.php">LOGOUT</a></div>       
            </div>
        </div>
        ';
    exit;} 
    echo '
    <div id="mapBg"></div>
    <div class="contentBg" id="profileBg">
        <div class="contentContainer" id="profileContainer">
            <div class="centerDiv" id="splitHeadline"><h1 class="gText" id="profileH1">Hello, '.$jUserId->firstname.'</h1><a href="logout.php" class="btnSmall"><b>LOGOUT</b></a></div>
            <div class="splitDiv"><p><b>USER</b></p></div>
            <div class="profileDiv">
                <div class="profileDiv1" id="'.$sProfileId.'" profile-type="users">
                    <label for="profileImgFileId"><img src="'.$jUserId->image.'" alt="profileImg" id="profileImg"></label>
                    <div>              
                        <form id="imgForm" style="width:auto;" enctype="multipart/form-data" method="POST">
                            <input data-type="image" name="imgFile" type="file" id="profileImgFileId">
                        </form>               
                    </div>
                    <form class="infoForm" method="POST">
                        <div><b>First name:</b></div><div><input id="profileInfoInput" maxlength="40" minlength="2" data-type="onlyLetters" data-min="2" data-max="40" data-update="firstname" type="text" value="'.$jUserId->firstname.'"></div>
                        <div><b>Last name:</b></div><div><input id="profileInfoInput" maxlength="40" minlength="2" data-type="onlyLetters" data-min="2" data-max="40" data-update="lastname" type="text" value="'.$jUserId->lastname.'"></div>
                        <div><b>Email:</b></div><div><input id="profileInfoInput" data-type="email" data-update="email" type="text" value="'.$jUserId->email.'"></div>
                        <div><b>Zip code:</b></div><div><input id="profileInfoInput" data-update="zip" type="text" value="'.$jUserId->zip.'"></div>
                        <div><b>Phone:</b></div><div><input id="profileInfoInput" data-update="phone" type="text" value="'.$jUserId->phone.'"></div>
                    </form>
                    <div class="leftDiv"><a href="delete-profile.php?type=users" class="btnSmall" id="btnDelete" onclick="return confirm(`Are you sure you want to delete your profile?`)"><b>DELETE PROFILE</b></a></div>    
                    <div class="centerDiv" id="updateMsg"></div>
                </div>
                <div class="profileDiv2">
    ';
    properties($sProfileId); echo '
                </div>
            </div>
        </div>
    </div>
    ';
}
if(isset($jProfiles->agents->$sProfileId)){
    $jAgentId = $jProfiles->agents->$sProfileId;
    if($jAgentId->verified != 1){
        echo '
        <div id="mapBg"></div>
        <div class="contentBg" id="profileBg">
            <div class="contentContainer" id="profileContainer">
                <div class="centerDiv"><p class="smallGtext">This account has not yet been activated, please check your email inbox for a verification link (Refresh this page or relog once verified)</p></div>
                <div class="centerDiv"></div>
                <div class="centerDiv"></div>
                <div class="centerDiv"><a href="logout.php">LOGOUT</a></div>
            </div>
        </div>
        ';
    exit;
    }
    echo '
    <div id="mapBg"></div>
    <div class="contentBg" id="profileBg">
        <div class="contentContainer" id="profileContainer">
            <div class="centerDiv" id="splitHeadline"><h1 class="gText" id="profileH1">Hello, '.$jAgentId->firstname.'</h1><a href="logout.php" class="btnSmall"><b>LOGOUT</b></a></div>
            <div class="splitDiv"><p><b>AGENT</b></p><div class="profileRightDiv"><p><b>PROPERTIES</b></p><a href="upload-property.php" class="btnSmall" id="btnUpload"><b>UPLOAD PROPERTY</b></a></div></div>
            <div class="profileDiv">
                <div class="profileDiv1" id="'.$sProfileId.'" profile-type="agents">
                    <label for="profileImgFileId"><img src="'.$jAgentId->image.'" alt="profileImg" id="profileImg"></label>
                    <div>              
                        <form id="imgForm" style="width:auto;" enctype="multipart/form-data" method="POST">
                            <input data-type="image" name="imgFile" type="file" id="profileImgFileId">
                        </form>               
                    </div>
                    <form class="infoForm" id="profileInfoForm" method="POST">
                        <div><b>First name:</b></div><div><input id="profileInfoInput" maxlength="40" minlength="2" data-type="onlyLetters" data-min="2" data-max="40" data-update="firstname" type="text" value="'.$jAgentId->firstname.'"></div>
                        <div><b>Last name:</b></div><div><input id="profileInfoInput" maxlength="40" minlength="2" data-type="onlyLetters" data-min="2" data-max="40" data-update="lastname" type="text" value="'.$jAgentId->lastname.'"></div>
                        <div><b>Email:</b></div><div><input id="profileInfoInput" data-type="email" data-update="email" type="text" value="'.$jAgentId->email.'"></div>
                        <div><b>Zip code:</b></div><div><input id="profileInfoInput" maxlength="4" minlength="4" data-type="optional-integer" data-min="4" data-max="4" data-update="zip" type="text" value="'.$jAgentId->zip.'"></div>
                        <div><b>Phone:</b></div><div><input id="profileInfoInput" maxlength="10" minlength="6" data-type="optional-integer" data-min="6" data-max="10" data-update="phone" type="text" value="'.$jAgentId->phone.'"></div>
                    </form>
                    <div class="leftDiv"><a href="delete-profile.php?type=agents" class="btnSmall" id="btnDelete"  onclick="return confirm(`Are you sure you want to delete your profile?`)"><b>DELETE PROFILE</b></a></div>    
                    <div class="centerDiv" id="updateMsg"></div>
                </div>
                <div class="profileDiv2">
    ';
    properties($sProfileId); echo '
                </div>
            </div>
        </div>
    </div>
    ';
}
function properties($sProfileId){
    $sjProperties = file_get_contents('properties.json');
    $jProperties = json_decode($sjProperties);
    
    foreach($jProperties as $jProperty){
        if($jProperty->seller == $sProfileId){
            echo '
            <div id="'.$jProperty->id.'" class="property profileProperty">
                <a href="delete-property.php?id='.$jProperty->id.'" class="btnSmall" id="btnDeleteProperty" onclick="return confirm(`Are you sure you want to remove the property?`)"><b>REMOVE</b></a>
                <img src="'.$jProperty->image.'" alt="PropertyImg" id="propertyImg">
                <div class="propertyInfo" id="agentPropertyInfo">
                    <form class="infoForm" id="PropertyInfoForm">
                        <div><b>Price £:</b></div><div><input id="propertyInfoInput" data-update="price" type="text" data-type="integer" maxlength="10" data-max="10" value="'.$jProperty->price.'"></div>
                        <div><b>Beds:</b></div><div><input id="propertyInfoInput" data-update="bds" type="text" data-type="integer" maxlength="3" data-max="3" value="'.$jProperty->bds.'"></div>
                        <div><b>Baths:</b></div><div><input id="propertyInfoInput" data-update="ba" type="text" data-type="integer" maxlength="3" data-max="3" value="'.$jProperty->ba.'"></div>
                        <div><b>Meter&#178:</b></div><div><input id="propertyInfoInput" data-update="m2" type="text" data-type="integer" maxlength="5" data-max="5" value="'.$jProperty->m2.'"></div>
                        <div><b>Area zip:</b></div><div><input id="propertyInfoInput" data-update="zip" type="text" data-type="integer" maxlength="4" data-max="4" minlength="4" data-min="4" value="'.$jProperty->zip.'"></div>
                        <div><b>Address:</b></div><div><input id="propertyInfoInput" data-update="address" type="text" data-type="string" maxlength="40" data-max="40" value="'.$jProperty->address.'"></div>
                        <div><b>City:</b></div><div><input id="propertyInfoInput" data-update="city" type="text" data-type="string" maxlength="20" data-max="20" value="'.$jProperty->city.'"></div>
                    </form>
                </div>
                <div class="propertyBottomLine"></div>
            </div>
            ';
        }
    }
}
?>
</body>
</html>