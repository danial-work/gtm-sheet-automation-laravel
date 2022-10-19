<?php
require_once base_path()."/public/util/google_setup.php";
//Reset OAuth access token
$google_client->revokeToken();
//Destroy entire session data.
session_destroy();
//redirect page to index.php
header('location:/new-home');
?>