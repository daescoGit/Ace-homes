<?php
session_start();
$pageTitle = 'Signup';
//if($_SESSION){header('Location: profile.php');} // to be or not to be
require_once(__DIR__.'/components/top.php'); // session_start()
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="validate.js"></script>
<?php
// backend validation, self invoking func
(function(){
    if(empty($_POST['txtEmail'])){
        return;
    }   
    if(empty($_POST['txtPassword'])){
        return;
    } 
    if(empty($_POST['txtFname'])){
        return;
    } 
    if(empty($_POST['txtLname'])){
        return;
    }  
    if(!filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL)){
        return;
    } // + verify unique email
    if(strlen($_POST['txtPassword']) < 6 || strlen($_POST['txtPassword']) > 80){
        return;
    }
    if(strlen($_POST['txtFname']) < 2 || strlen($_POST['txtFname']) > 40){
        return;
    }
    if(strlen($_POST['txtLname']) < 2 || strlen($_POST['txtLname']) > 40){
        return;
    }
    if(!ctype_alpha($_POST['txtFname'])){ // checks for alphabetic 
        return;
    } 
    if(!ctype_alpha($_POST['txtLname'])){
        return;
    }
    if(!empty($_POST['txtZip'])){
        if(!ctype_digit($_POST['txtZip'])){
            return;
        }  
        if(strlen($_POST['txtZip']) < 4 || strlen($_POST['txtZip']) > 4){
            return;
        }
    }
    if(!empty($_POST['txtPhone'])){
        if(!ctype_digit($_POST['txtPhone'])){
            return;
        }  
        if(strlen($_POST['txtPhone']) < 6 || strlen($_POST['txtPhone']) > 10){
            return;
        }
    }
    
    if(isset($_POST['boxCheck']) && $_POST['boxCheck'] == 'Yes'){
        profileType('agents');
    }else{
        profileType('users');
    }
})();

function profileType($jUtype){
    $sjProfiles = file_get_contents('profiles.json');
    $jProfiles = json_decode($sjProfiles);
    
    $jProfile = new stdClass();
    $jProfile->email = $_POST['txtEmail'];
    $jProfile->password = $_POST['txtPassword'];
    $jProfile->firstname = $_POST['txtFname'];
    $jProfile->lastname = $_POST['txtLname'];
    $jProfile->zip = $_POST['txtZip'];
    $jProfile->phone = $_POST['txtPhone'];
    $jProfile->verified = 0;
    $jProfile->profileType = $jUtype;
    $jProfile->image = 'images/defaultProfile.jpg';
    
    $sKey = bin2hex(random_bytes(10));
    $jProfile->activationKey = $sKey;
    $sUid =  bin2hex(random_bytes(10));
    
    $jProfiles->$jUtype->$sUid = $jProfile;
    $sjProfiles = json_encode($jProfiles, JSON_PRETTY_PRINT);   
    file_put_contents('profiles.json', $sjProfiles);
    
    echo '
    <script>
    $.ajax({
        url:"apis/activate-email/api-send-email.php?id='.$sUid.'&key='.$sKey.'"
    })
    .done(function(){
        document.getElementById("signupFormContainer").classList.add("hidden")
        document.getElementById("verifyEmailContainer").classList.remove("hidden")
        console.log("Email sent")
    })
    .fail(function(){
        console.log("something went wrong, email not sent")
    })
    </script>';
}; 
?>

<div id="mapBg"></div>
<div class="contentBg">
    <div class="contentContainer" id="signupFormContainer">
        <div class="centerDiv"><h1 class="gText">Register profile</h1></div>
        <div class="centerDiv"><p class="smallGtext">Sign up to manage properties, bookmark homes and more.</p></div>
        <div class="centerDiv">
        <form class="signupForm" id="frmSignup" method="POST">
            <input name="txtEmail" data-type="email" placeholder="Email">
            <p class="smallGtext2">6 to 80 characters</p>
            <input name="txtPassword" type="password" maxlength="80" minlength="6" data-type="string" data-min="6" data-max="80" placeholder="Password">
            <input name="txtFname" type="text" maxlength="40" minlength="2" data-type="onlyLetters" data-min="2" data-max="40" placeholder="First name">
            <input name="txtLname" type="text" maxlength="40" minlength="2" data-type="onlyLetters" data-min="2" data-max="40" placeholder="Last name">
            <input name="txtZip" type="text" maxlength="4" minlength="0" data-type="optional-integer" data-min="4" data-max="4" placeholder="Zip code (optional)">
            <input name="txtPhone" type="text" maxlength="10" minlength="0" data-type="optional-integer" data-min="6" data-max="10" type="text" placeholder="Phone number (optional)">
            <div id="checkDiv"><input name="boxCheck" type="checkbox" value="Yes" id="boxCheck">Agent Signup</div>
            <button id="btnSignup" onclick="return formValidate('#frmSignup');"  data-wait="PROCESSING ..."><b>SIGN UP</b></button>
        </form>
    </div>
    </div>

    <div class="hidden contentContainer" id="verifyEmailContainer">
        <div></div>
        <div class="centerDiv"><h1>Thank you for registering</h1></div>
        <div class="centerDiv"><p class="smallGtext"><p>We have sent you a welcome email - please <span style="color: #29b6f6;">visit the link in the email</span> to activate your account.</p><p>(Remember to check your spam folder)</p></div>
    <div class="centerDiv"><img src="images/mail2.png" alt="mail" width="250px"></div>
    </div>

    <div class="hidden contentContainer" id="errorEmailContainer">
        <div></div>
        <div class="centerDiv"><h1>Something went wrong</h1></div>
        <div class="centerDiv"><p class="smallGtext">We could not send your verification email - Our servers may have encountered an issue.</p><p class="smallGtext">Please try again in a moment, if the problem persists contact our technical support (LINK)</p></div>
    </div>
</div>

</body>
</html>