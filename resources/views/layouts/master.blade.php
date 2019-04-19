<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | Client Portal</title>

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

    <!-- Local CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield('imports')
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

            <div id="app content-area" class="col-lg-10 col-md-10">
                @yield('content')
            </div>
        </div>
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
</body>
</html>
