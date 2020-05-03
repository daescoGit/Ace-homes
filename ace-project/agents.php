<?php
$pageTitle = 'Agents';
require_once(__DIR__.'/components/top.php');
$sjProfiles = file_get_contents('profiles.json');
$jProfiles = json_decode($sjProfiles);
$jAgents = $jProfiles->agents;

echo '
<div id="mapBg"></div>
<div class="contentBg" id="profileBg">
    <div class="contentContainer" id="agentsContainer">
';
        foreach($jAgents as $jAgent){
            //$sProfileId = '12f3dc7bacaf57b8a14f'; //test
            echo '  
                <div class="profileDiv3">
                    <div class="profileDiv4">
                        <img src="'.$jAgent->image.'" alt="profileImg" id="profileImg">
                        <div class="profileDiv5">
                            <div><b>Name:</b> '.$jAgent->firstname.' '.$jAgent->lastname.'</div>
                            <div><b>Email:</b> '.$jAgent->email.'</div>
                            <div><b>Zip code:</b> '.$jAgent->zip.'</div>
                            <div><b>Phone:</b> '.$jAgent->phone.'</div>
                        </div>
                    </div>
                </div>
            ';
        }
echo '
    </div>
</div>
';
?>
<!-- <script>
function properties($sProfileId){
    $sjProperties = file_get_contents('properties.json');
    $jProperties = json_decode($sjProperties);
    
    foreach($jProperties as $jProperty){
        if($jProperty->seller == $sProfileId){
            echo '<div id="'.$jProperty->id.'" class="property profileProperty">
            <a href="delete-property.php?id='.$jProperty->id.'" class="btnSmall" id="btnDeleteProperty"><b>DELETE</b></a>
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
          </div>'         
        ;}
    }
}
</script> -->
</body>
</html>