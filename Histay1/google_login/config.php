<?php

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('517486861474-guetd7ch5td04asd05pl9hkjle2ee6cp.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('qRQlCa40vpbhdlV5BEDJr5_J');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://ecrcheckin.in/google_login/index.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?> 