<?php
    require_once base_path()."/public/util/google_setup.php";
    require_once base_path()."/public/util/php_user_def_functions.php";

    if(!isset($_SESSION['access_token'])) { //|| !isset($_COOKIE['ga_at'])
        //Create a URL to obtain user authorization
        $google_login_url = "login-google";
        $google_login_text = "Login with Google";
        $greetings = "Hi, please log in with your Google Account.";
        $access_token = "none";
        setcookie('ga_at',"", time() - 3600);
    }
    else {
        $google_login_url = "logout-google";
        $google_login_text = "Logout from Google";
        $greetings = "Hi, ".$_SESSION['user_first_name']." ".$_SESSION['user_last_name'];
        $access_token = $_SESSION['access_token'];
        
        // setcookie('ga_at',$access_token);
        setcookie('ga_at_encode',base64_encode($access_token));

        // print_r($access_token . "<br/>");
        // print_r(base64_encode($access_token) . "<br/>");
        // print_r($_SESSION['created_ts'] . PHP_EOL);
        // print_r($_SESSION['expires_in_ts'] . PHP_EOL);
        print_r(time() . PHP_EOL);
        print_r($_SESSION['expires_in_ts'] + $_SESSION['created_ts'] . PHP_EOL);
        

        if(time() > $_SESSION['expires_in_ts'] + $_SESSION['created_ts'])
        {
            print_r("not fine");
            header('location:/logout-google');
        }
        else
        {
            print_r("should be fine");
        }
    }
?>

@extends('layouts.general')
@section('content')
    <div class="d-flex justify-content-center align-items-center position-absolute" id="loading-item">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="loader spinner loading-spinner" role="status"></div><div class="spinner-container loading-spinner"></div>
        <div class="container">
            <div class="row pt-3 pb-3 my-3">
                <div class="col-md-6">
                    <h2>GTM Tag Lister</h2>
                </div>
            </div>
        </div>
        <div class="container border rounded my-3 bg-white">
            <div class="row py-3">
                <div class="col-md-4" id="col_login">
                    <a class="btn btn-outline-dark" href=<?php echo $google_login_url; ?> role="button" style="text-transform:none" id="google-login">
                    <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
                    <?php echo $google_login_text; ?>
                    </a>
                </div>
                <div class="col-md-5 mt-auto mb-auto" id="col_greet">
                    <p id="text_greet"><?php echo $greetings; ?></p>
                </div>
            </div>
        </div>
        <div class="container border rounded my-3 bg-white">
            <div class="row py-3">
                <div class="col-md-12">
                    <h3>
                        GA3 Tag Lister
                    </h3>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col-10">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td style="width: 19%">
                                    <label for="GTM-account">Account Selected:</label>
                                    
                                </td>
                                <td>
                                    <select class="selectpicker" id="GTM-account-dropdown" data-live-search="true" disabled>
                                        
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="GTM-container">Container Selected:</label>
                                </td>
                                <td>
                                    <select class="selectpicker" id="GTM-container-dropdown" data-live-search="true" disabled>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="GTM-workspace">Workspace Selected:</label>
                                </td>
                                <td>
                                    <select class="selectpicker" id="GTM-workspace-dropdown" data-live-search="true" disabled>
                                        
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col-10">
                    <a class="btn btn-outline-dark disabled" href="#" role="button" style="text-transform:none" id="generate-sheet">
                        Generate Sheet
                    </a>
                </div>
            </div>

            <div class="row mt-3 mb-3">
                <div class="col-10">
                    <p id="sheet-title" class="p-1"></p><br>
                    <a id="sheet-link" href="" target="_blank" class="p-1"></a><p id="sheet-text"></p>
                </div>
            </div>
        </div>
        <div class="container border rounded my-3 bg-white">
            <div class="row py-3">
                <div class="col-md-12">
                    <h3>
                        GA4 Tag Migration Automation
                    </h3>
                </div>
            </div>
            <div class="row py-3">
                <div class="col-md-2 justify-content-center align-self-center">
                    <div>
                        Google Sheet ID
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-text bg-white" id="basic-addon3">https://docs.google.com/spreadsheets/d/</span>
                        <input type="text" class="form-control bg-white" id="basic-url" aria-describedby="basic-addon3">
                        <span class="input-group-text bg-white" id="basic-addon2">/edit</span>
                    </div>
                </div>
            </div>
            <!-- <div class="row py-3">
                <div class="col-md-2">
                    <div class="heading-1"><span>OR</span></div>
                </div>
            </div>
            <div class="row py-3">
                <div class="col-md-2 justify-content-center align-self-center">
                    <div>
                        JSON input file
                    </div>
                </div>
                <div class="col-md-9">
                    <input class="form-control" type="file" id="formFile" accept=".json">
                </div>
            </div> -->

            <div class="row mt-3 mb-3">
                <div class="col-10">
                    <a class="btn btn-outline-dark disabled" href="#" role="button" style="text-transform:none" id="generate-sheet">
                        Generate Sheet
                    </a>
                </div>
            </div>
        </div>
        <div class="alert alert-success w-50 mt-5 position-absolute top-0 start-50 translate-middle" id="alert-login-success" role="alert">
            You are logged in.
        </div>
        <div class="alert alert-primary w-50 mt-5 position-absolute top-0 start-50 translate-middle" id="alert-logout-success" role="alert">
            You are logged out.
        </div>
        <script>
            window.onload = function() {
                if (window.jQuery) {  
                    // jQuery is loaded  
                    console.log("jQuery Worked");
                } else {
                    // jQuery is not loaded
                    console.log("jQuery did not Work");
                }
                $( document ).ready(function() {
                    $.getScript("js/util.js", function(){ //make sure the script is loaded before running code below
                        <?php 
                        if(isset($_SESSION['access_token']))
                        {
                        ?>
                            setup_dropdown();
                        <?php
                        }
                        else
                        {
                        ?>
                            alert_popup('#alert-logout-success',2000);
                        <?php
                        }
                        ?>
                    });
                    
                });
            }
        </script>
    </div>
@endsection