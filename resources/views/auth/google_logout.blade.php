<?php
require_once base_path()."/public/util/google_setup.php";
//Reset OAuth access token
$google_client->revokeToken();
//Destroy entire session data. ga_at_encode
session_destroy();
//Remove Cookie if exist
if (isset($_COOKIE['ga_at_encode'])) {
    unset($_COOKIE['ga_at_encode']);
}
//redirect page to index.php
header('location:/new-home');
?>