<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '757450436773-bqu5slpqcguvtfk5jvbm4g6hc8vmckj2.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'Hnh2Ietqoi6VvHaf1qWfgHuY'; //Google client secret
$redirectURL = 'http://localhost/drivingo_new/d6/glogin/'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>