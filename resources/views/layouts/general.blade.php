
<!DOCTYPE html>
<html lang="en">
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

    @yield('content')

    </body>
</html>