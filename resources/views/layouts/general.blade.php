
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
            .loader {
                background-color: rgba(255,255,255,0.75);
                height: 95%;
                width: 100%;
                opacity:1;
                z-index: 5;
                -webkit-transition: all 0.75s;
                transition:all 0.75s;
            }

            .alert {
                display:none;
                z-index: 10;
            }
        </style>

        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script> -->

    </head>

    <body class="overflow-hidden">

    @yield('content')

    </body>
</html>