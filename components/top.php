<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Lato|Playfair+Display|Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="app.css">
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js'></script> <!-- check for page before load? -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css' rel='stylesheet' /> <!-- check for page before load? -->
    <title><?= $pageTitle ?></title>
<link rel="apple-touch-icon" sizes="180x180" href="/ace/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/ace/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/ace/favicon-16x16.png">
<link rel="manifest" href="/ace/site.webmanifest">
<link rel="mask-icon" href="/ace/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="/ace/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="/ace/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
</head>
<body>
<nav>
    <div><a href="index.php"><img src="images/ace2.png" alt="logo" id="logo"></a></div>
    <div <?php if($pageTitle == 'Homes'){echo 'class="active"';} ?>><a href="homes.php">Homes</a></div><div id="vline"></div>
    <div <?php if($pageTitle == 'Signup'){echo 'class="active"';} ?>><a href="signup.php">Sign up</a></div><div id="vline"></div>
    <div <?php if($pageTitle == 'Login' || $pageTitle == 'Profile' ){echo 'class="active"';} ?>> <!-- active style -->
        <a href="<?php if($_SESSION){echo 'profile.php';}else{echo 'login.php';}?>"> <!-- link destination -->
        <?php if($_SESSION){echo 'Profile';}else{echo 'Login';} ?></a></div><div id="vline"></div> <!-- displayed link name -->
    <div <?php if($pageTitle == 'Agents'){echo 'class="active"';} ?>><a href="agents.php">Agents</a></div>
</nav>


