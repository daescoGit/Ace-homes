<?php
session_start();
$pageTitle = 'Login';
if($_SESSION){header('Location: profile.php');}
(function(){
    if(empty($_POST['txtEmail'])){
        return;
    }   
    if(empty($_POST['txtPassword'])){
        return;
    }   
    if(!filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL)){
        return;
    }
    if(strlen($_POST['txtPassword']) < 6 || strlen($_POST['txtPassword']) > 80){
        return;
    }
    
    $sjProfiles = file_get_contents('profiles.json');
    $jProfiles = json_decode($sjProfiles);
    $jPtypeUser = $jProfiles->users;
    $jPtypeAgent = $jProfiles->agents;
    
    $wrongLogin = false;
    foreach($jPtypeUser as $sKey => $jProfile){
        if($jProfile->email != $_POST['txtEmail'] || $jProfile->password != $_POST['txtPassword']){ 
            $wrongLogin = true;
        }else{
            $_SESSION['sProfileId'] = $sKey;
            header('Location: profile.php');
            exit;
        }
    }
    foreach($jPtypeAgent as $sKey => $jProfile){
        if($jProfile->email != $_POST['txtEmail'] || $jProfile->password != $_POST['txtPassword']){ 
            $wrongLogin = true;         
        }else{
            $_SESSION['sProfileId'] = $sKey;
            header('Location: profile.php');  
            exit;         
        }
    }
    if($wrongLogin == true){header('Location: login.php?li=0');}
})(); 
require_once(__DIR__.'/components/top.php'); // session_start()
?>

<script src="validate.js"></script>

<div id="mapBg"></div>
<div class="contentBg">
    <div class="contentContainer">
        <div class="centerDiv"><h1 class="gText">Welcome back</h1></div>
        <div class="centerDiv"><p class="smallGtext">Not registered yet? head over to the <a href="signup.php">Signup</a> page</p></div>
        <div class="centerDiv">
            <form class="profileForm" id="frmLogin" method="POST">
                <input name="txtEmail" data-type="email" placeholder="Email">
                <p class="smallGtext2">6 to 80 characters</p>
                <input name="txtPassword" type="password" maxlength="80" minlength="6" data-type="string" data-min="6" data-max="80" placeholder="Password">
                <button id="btnLogin" onclick="return formValidate('#frmLogin');"><b>LOGIN</b></button>
            </form>
        </div>
    <div class="centerDiv"><p><a href="#">Forgot your password?</a></p></div>
    <div class="centerDiv"><?php if(empty($_GET)){}else if($_GET['li'] == 0){echo '<p style="color:rgb(255, 128, 128);">Incorrect credentials</p>';}?></div>
    </div>
</div>


</body>
</html>