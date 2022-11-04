<?php
//Include Google Client Library for PHP autoload file
require_once base_path()."/vendor/autoload.php";
  
$strJsonFileContents = json_decode(file_get_contents(base_path()."/secret/client_secret_438402232662-rm5mbntbs07q5rk5ua0afdtubr8u6mgt.apps.googleusercontent.com.json"));

// init configuration
$clientID = $strJsonFileContents->web->client_id;
$clientSecret = $strJsonFileContents->web->client_secret;
$redirectUri = "https://pc-83.ad.kasatria.com:20006/new-home"; // $strJsonFileContents->web->redirect_uris[0];

//Make object of Google API Client for call Google API
$google_client = new Google_Client();
 
//Set the OAuth 2.0 Client ID
$google_client->setClientId($clientID);
 
//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret($clientSecret);
 
//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri($redirectUri);
 
//set scope
$google_client->setScopes(['https://www.googleapis.com/auth/spreadsheets.readonly','https://www.googleapis.com/auth/tagmanager.readonly','https://www.googleapis.com/auth/presentations']);

//add scope
$google_client->addScope('email');
 
$google_client->addScope('profile');
 
//start session on web page
session_start();
 
//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
//It will Attempt to exchange a code for an valid authentication token.
$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

$_SESSION["g_token"] = $token;


//This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
if(!isset($token['error']))
{
    //Set the access token used for requests
    $google_client->setAccessToken($token['access_token']);
    //Store "access_token" value in $_SESSION variable for future use.
    $_SESSION['access_token'] = $token['access_token'];
    $_SESSION['created_ts'] = $token['created'];
    $_SESSION['expires_in_ts'] = $token['expires_in'];
    //Create Object of Google Service OAuth 2 class
    $google_service = new Google_Service_Oauth2($google_client);
    //Get user profile data from google
    $data = $google_service->userinfo->get();
    //Below you can find Get profile data and store into $_SESSION variable
    if(!empty($data['given_name']))
    {
        $_SESSION['user_first_name'] = $data['given_name'];
    }
    if(!empty($data['family_name']))
    {
        $_SESSION['user_last_name'] = $data['family_name'];
    }
    if(!empty($data['email']))
    {
        $_SESSION['user_email_address'] = $data['email'];
    }
    if(!empty($data['gender']))
    {
        $_SESSION['user_gender'] = $data['gender'];
    }
    if(!empty($data['picture']))
    {
        $_SESSION['user_image'] = $data['picture'];
    }
    }
}

?>