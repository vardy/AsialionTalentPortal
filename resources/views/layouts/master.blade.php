<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="theme-color" content="#E91D25">
    <meta name="description" content="Portal for employees at AsiaL10n.">
    <meta name="author" content="Jarred Vardy">
    <meta name="keywords" content="Translation,Localisation,Portal,Talent,Employee,Asialion,Singapore,Bangkok">

    <title>@yield('title') | Talent Portal</title>

    <!-- DataTables / JQuery -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/r-2.2.2/sl-1.3.0/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/r-2.2.2/sl-1.3.0/datatables.min.js"></script>

    <!-- Bootstrap / Popper -->
    <!-- Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/superhero/bootstrap.min.css" rel="stylesheet" integrity="sha384-LS4/wo5Z/8SLpOLHs0IbuPAGOWTx30XSoZJ8o7WKH0UJhRpjXXTpODOjfVnNjeHu" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Local CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/cookie_consent.css') }}" rel="stylesheet">

    @yield('imports')
</head>

<body>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="container">
        <div class="row">
            <div id="side-nav">

                <img src="/storage/files/AL_LOGO.png" alt="AsiaLion Logo">

                <div id="talent-portal-text-header-container">
                    <p id="talent-portal-text-header">Talent Portal</p>
                </div>

                <div id="side-nav-body">
                    <ul>
                        <a href="{{ route('invoices') }}"><li class="@yield('currently_selected_invoices')"><span>Invoices</span></li></a>
                        <a href="{{ route('nda') }}"><li class="@yield('currently_selected_nda')"><span>NDA</span></li></a>
                        <a href="{{ route('personal_details') }}"><li class="@yield('currently_selected_personal_details')"><span>Personal Details</span></li></a>
                        <a target="_blank" rel="noopener noreferrer" href="{{ route('careers') }}"><li><span>Careers</span></li></a>
                        @auth
                            @if (auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin') }}"><li><span class="admin-link">Admin Panel</span></li></a>
                            @endif
                        @endauth
                    </ul>
                </div>

                @auth
                    <div id="logout-section">
                        <div class="social-media-section">
                            <span class="social-media-icon"><a href="https://www.facebook.com/asial10n"><i class="fab fa-facebook-square"></i></a></span>
                            <span class="social-media-icon icon-last"><a href="https://www.linkedin.com/company/asial10n"><i class="fab fa-linkedin"></i></a></span>
                        </div>

                        <div class="privacy-section">
                            <a target="_blank" rel="noopener noreferrer" href="{{ route('privacy_policy') }}"><span class="privacy-item">Privacy Policy</span></a>
                        </div>

                        <div class="horizontal-rule"></div>

                        <img src="{{ auth()->user()->getProfilePicturePath(auth()->user()) }}" alt="Your profile picture.">

                        <ul>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                <li class="relative"><span>Logout</span></li></a>
                        </ul>
                    </div>
                @endauth
            </div>

            <div id="content-area">
                @yield('content')
            </div>
        </div>

        <div id="app"></div>
    </div>

    <!-- Local JS Scripts -->
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>

    <script>
        var table = $('.table').DataTable({
            dom: "<'row'<'col-sm-12 col-md-6 col-lg-6'l><'col-sm-12 col-md-6 col-lg-6'f>>" +
                "rt" +
                "<'row'<'col-sm-12 col-md-6 col-lg-6'B><'col-sm-6 col-md-6 col-lg-6'p><'col-sm-6 col-md-12 col-lg-12'i>>",
            colReorder: true,
            buttons: [
                'copy', 'excel', 'pdf'
            ],
        });
    </script>

    @include('cookieConsent::index')
</body>
</html>
