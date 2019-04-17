<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Client Portal</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">

            <div id="side-nav" class="col-lg-2 col-md-2">

                <h1>Client<br>Portal</h1>

                <div id="side-nav-body">
                    <ul>
                        <li><span><a href="{{ route('invoices') }}">Invoices</a></span></li>
                        <li><span><a href="{{ route('nda') }}">NDA</a></span></li>
                        <li><span><a href="{{ route('personal_details') }}">Personal Details</a></span></li>
                        <li><span><a href="{{ route('careers') }}">Careers</a></span></li>
                    </ul>
                </div>
            </div>

            <div id="content-area" class="col-lg-10 col-md-10">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Local JS Scripts -->
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
