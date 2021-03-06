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

        <title>Login | Talent Portal</title>

        <!-- Bootstrap / Popper -->
        <!-- Bootstrap -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- Particles.JS
        <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> -->

        <!-- Local CSS -->
        <link href="{{ mix('css/login.css') }}" rel="stylesheet">
        <link href="{{ mix('css/cookie_consent.css') }}" rel="stylesheet">
    </head>

    <body>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div id="top-bar"></div>

    <div class="custom-container">

        <div class="vertical-centered-containers">

            <div class="brand-image-container">
                <div class="frame">
                    <img src="/storage/files/AL_LOGO_WHITE_SCALEUP.png" alt="AsiaLion Logo" class="brand-image">
                </div>
            </div>

            <div id="login-form" class="login-area">
                <div class="text-center">
                    <p class="small-heading">{{ __('general.talent_portal_heading') }}</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">{{ __('login.email_address_label') }}</label>

                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('login.password_label') }}</label>

                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-light">
                            {{ __('login.login_button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="app"></div>
    </div>

    <!-- Local JS Scripts -->
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    <!-- <script src="{{ mix('/js/particlesjs.js') }}"></script> -->

    @include('cookieConsent::index')

    </body>
</html>
