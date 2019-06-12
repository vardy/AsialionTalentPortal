<div class="js-cookie-consent cookie-consent">

    <span class="cookie-consent__message">
        {{ __('general.consent_message') }} <a href="{{ route('privacy_policy') }}" style="color: white;"><u>{{ __('general.privacy_policy') }}</u>.</a>
    </span>

    <button class="btn btn-outline-success js-cookie-consent-agree cookie-consent__agree">
        {{ trans('cookieConsent::texts.agree') }}
    </button>

</div>
