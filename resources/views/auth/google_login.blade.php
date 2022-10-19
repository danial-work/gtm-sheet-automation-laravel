<?php
    require_once base_path()."/public/util/google_setup.php";
    if(!isset($_SESSION['access_token'])) {
        header('location:'.$google_client->createAuthUrl());
    }
    else {
        header('location:/new-home');
    }
?>