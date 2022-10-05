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
        
        setcookie('ga_at',$access_token);

        // print_r($access_token . PHP_EOL);
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
<!doctype html>
<html> <!-- lang="{{ str_replace('_', '-', app()->getLocale()) }}" -->
    <head>
        <meta charset="utf-8">
        <title>GTM Tag Lister</title>

        <!-- Scripts -->
        <script src="{{ isSecure() ? secure_asset('js/app.js') : asset('js/app.js') }}" async defer></script>
        <!-- Styles -->
        <link href="{{ isSecure() ? secure_asset('css/app.css') : asset('css/app.css') }}" rel="stylesheet">
        <style>
            .loading-spinner
            {
                opacity:0;
            }

            .alert {
                display:none
            }

            .spinner {
                display: block;
                position: fixed;
                z-index: -1; /* High z-index so it is on top of the page */ 
                top: 50%;
                right: 50%; /* or: left: 50%; */
                margin-top: -..px; /* half of the elements height */
                margin-right: -..px; /* half of the elements widht */
            }

            .spinner-container{
                background-color: rgba(0, 0, 0, 0.2);
                z-index: -1;
                width: 100%;
                height: 100vh;
                position: fixed;
                top:0;
                left:0;
            }

            .loader {
                ;border: 8px solid #f3f3f3; /* Light grey */
                border-top: 8px solid #333333; /* Blue */
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 0.9s linear infinite
            }

            p{
                display:inline;
            }

            .heading-1{
                position:relative;
                text-align: center
            }

            .heading-1:before {
                content: "";
                display: block;
                border-top: solid 2px #bebebe;
                width: 100%;
                height: 2px;
                position: absolute;
                top: 50%;
                z-index: 0;
            }
            
            .heading-1 span {
                background: #fff;
                padding: 0 10px;
                position: relative;
                z-index: 1;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>

        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script> -->

    </head>
    <body>
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
    </body>
</html>