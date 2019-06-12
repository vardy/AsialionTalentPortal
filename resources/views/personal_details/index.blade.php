@extends('layouts.master')

@section('title', 'Personal Details')

@section('currently_selected_personal_details', 'currently-selected')

@section('imports')
    <link href="{{ mix('css/personal_details.css') }}" rel="stylesheet">
@stop

@section('content')
    <h1>{{ __('personal_details.personal_details_heading') }}</h1>

    <p id="required_flavour_text" class="required"><span>*</span>{{ __('personal_details.required') }}</p>

    @if($user->hasCV)
        <p id="locked_fields_text">{{ __('personal_details.changes_notice') }} <a class="subtle-anchor" href="mailto:payment@asialion.com">payment@asialion.com</a>.</p>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success-message'))
        <div class="alert alert-success">
            <p>{{ session('success-message') }}</p>
        </div>
    @endif

    <form id="form_personal_details" method="POST" action="{{ route('personal_details') }}/{{ $user->id }}" enctype=multipart/form-data>
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <input type="text" class="hidden-field" name="first_name" value="{{ $user->personalDetails->first_name }}">
        <input type="text" class="hidden-field" name="last_name" value="{{ $user->personalDetails->last_name }}">
        <input type="text" class="hidden-field" name="email" value="{{ $user->personalDetails->email }}">

        <input type="text" class="hidden-field" name="mobile_number" value="{{ $user->personalDetails->mobile_number }}">
        <input type="text" class="hidden-field" name="home_number" value="{{ $user->personalDetails->home_number }}">

        <input type="text" class="hidden-field" name="account_name" value="{{ $user->personalDetails->account_name }}">
        <input type="text" class="hidden-field" name="account_number" value="{{ $user->personalDetails->account_number }}">
        <input type="text" class="hidden-field" name="bank_name" value="{{ $user->personalDetails->bank_name }}">
        <input type="text" class="hidden-field" name="swift_code" value="{{ $user->personalDetails->swift_code }}">
        <input type="text" class="hidden-field" name="bank_address" value="{{ $user->personalDetails->bank_address }}">

        <!-- Basic user details -->
        <div class="row">
            <div class="form-group col">
                <label for="first_name" class="required">{{ __('personal_details.first_name') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" id="first_name" name="first_name" rows="1" required @if($user->personalDetails->first_name) disabled @endif >@if(old('first_name')){{ old('first_name') }}@else{{ $user->personalDetails->first_name }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="last_name" class="required">{{ __('personal_details.last_name') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" id="last_name" name="last_name" rows="1" required @if($user->personalDetails->last_name) disabled @endif >@if(old('last_name')){{ old('last_name') }}@else{{ $user->personalDetails->last_name }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="email" class="required">{{ __('personal_details.email') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" rows="1" required @if($user->personalDetails->email) disabled @endif >@if(old('email')){{ old('email') }}@else{{ $user->personalDetails->email }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="skype_id">{{ __('personal_details.skype') }}</label>
                <textarea class="form-control {{ $errors->has('skype_id') ? ' is-invalid' : '' }}" id="skype_id" name="skype_id" rows="1">@if(old('skype_id')){{ old('skype_id') }}@else{{ $user->personalDetails->skype_id }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="qq">{{ __('personal_details.qq') }}</label>
                <textarea class="form-control {{ $errors->has('qq') ? ' is-invalid' : '' }}" id="qq" name="qq" rows="1">@if(old('qq')){{ old('qq') }}@else{{ $user->personalDetails->qq }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="linkedin">{{ __('personal_details.linkedin') }}</label>
                <textarea class="form-control {{ $errors->has('linkedin') ? ' is-invalid' : '' }}" id="linkedin" name="linkedin" rows="1">@if(old('linkedin')){{ old('linkedin') }}@else{{ $user->personalDetails->linkedin }}@endif</textarea>
            </div>
        </div>

        <!-- Country of residence -->
        <div class="row">
            <div class="form-group col">
                <label for="country_of_residence" class="label-block required">{{ __('personal_details.country_of_residence') }} <span>*</span></label>
                <select class="form-group {{ $errors->has('country_of_residence') ? ' is-invalid' : '' }}" id="country_of_residence" name="country_of_residence" required>
                    <option selected>...</option>
                    @foreach($countries as $country)
                        <option @if($country->name == $user->personalDetails->country_of_residence) selected @endif>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Phone numbers -->
        <div class="row">
            <div class="form-group col">
                <label for="mobile_number" class="required">{{ __('personal_details.mobile_number') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" id="mobile_number" name="mobile_number" rows="1" required @if($user->personalDetails->mobile_number) disabled @endif >@if(old('mobile_number')){{ old('mobile_number') }}@else{{ $user->personalDetails->mobile_number }}@endif</textarea>
                <small id="mobile_number_small_text" class="form-text text-muted">{{ __('personal_details.mobile_number_subtext') }}</small>
            </div>

            <div class="form-group col">
                <label for="home_number">{{ __('personal_details.home_number') }}</label>
                <textarea class="form-control {{ $errors->has('home_number') ? ' is-invalid' : '' }}" id="home_number" name="home_number" rows="1" @if($user->personalDetails->home_number) disabled @endif >@if(old('home_number')){{ old('home_number') }}@else{{ $user->personalDetails->home_number }}@endif</textarea>
            </div>
        </div>

        <!-- Education/Experience -->
        <div class="row">
            <div class="form-group col">
                <label for="highest_education" class="required">{{ __('personal_details.highest_education') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('highest_education') ? ' is-invalid' : '' }}" id="highest_education" name="highest_education" rows="3" required>@if(old('highest_education')){{ old('highest_education') }}@else{{ $user->personalDetails->highest_education }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="work_experience" class="required">{{ __('personal_details.work_experience') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('work_experience') ? ' is-invalid' : '' }}" id="work_experience" name="work_experience" rows="3" required>@if(old('work_experience')){{ old('work_experience') }}@else{{ $user->personalDetails->work_experience }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="industry_specialization" class="required">{{ __('personal_details.industry_specialization') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('industry_specialization') ? ' is-invalid' : '' }}" id="industry_specialization" name="industry_specialization" rows="3" required>@if(old('industry_specialization')){{ old('industry_specialization') }}@else{{ $user->personalDetails->industry_specialization }}@endif</textarea>
                <small id="industry_specialization_small_text" class="form-text text-muted">{{ __('personal_details.industry_specialization_subtext') }}</small>
            </div>

            <div class="form-group col">
                <label for="language_pairs" class="required">{{ __('personal_details.language_pairs') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('language_pairs') ? ' is-invalid' : '' }}" id="language_pairs" name="language_pairs" rows="3" required>@if(old('language_pairs')){{ old('language_pairs') }}@else{{ $user->personalDetails->language_pairs }}@endif</textarea>
                <small id="language_pairs_small_text" class="form-text text-muted">{{ __('personal_details.language_pairs_subtext') }}</small>
            </div>
        </div>

        <!-- Non-required extra info. Tools and turnaround -->
        <div class="row">
            <div class="form-group col">
                <label for="tools">{{ __('personal_details.tools') }}</label>
                <textarea class="form-control {{ $errors->has('tools') ? ' is-invalid' : '' }}" id="tools" name="tools" rows="2">@if(old('tools')){{ old('tools') }}@else{{ $user->personalDetails->tools }}@endif</textarea>
                <small id="tools_small_text" class="form-text text-muted">{{ __('personal_details.tools_subtext') }}</small>
            </div>

            <div class="form-group col">
                <label for="turnaround_per_day">{{ __('personal_details.turnaround_per_day') }}</label>
                <textarea class="form-control {{ $errors->has('turnaround_per_day') ? ' is-invalid' : '' }}" id="turnaround_per_day" name="turnaround_per_day" rows="1">@if(old('turnaround_per_day')){{ old('turnaround_per_day') }}@else{{ $user->personalDetails->turnaround_per_day }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <h2>{{ __('personal_details.rates_heading') }}</h2>
        </div>

        <!-- Currency -->
        <div class="row">
            <div class="form-group col">
                <label id="currency_used_label" for="currency_used" class="label-block required">{{ __('personal_details.currency_used') }} <span>*</span></label>
                <select class="form-group {{ $errors->has('currency_used') ? ' is-invalid' : '' }}" id="currency_used" name="currency_used" required>
                    <option selected>{{ __('personal_details.usd') }}</option>
                    <option {{ $user->personalDetails->currency_used == "SGD" ? 'selected' : '' }}>{{ __('personal_details.sgd') }}</option>
                    <option {{ $user->personalDetails->currency_used == "THB" ? 'selected' : '' }}>{{ __('personal_details.thb') }}</option>
                    <option {{ $user->personalDetails->currency_used == "RMB" ? 'selected' : '' }}>{{ __('personal_details.rmb') }}</option>
                    <option {{ $user->personalDetails->currency_used == "JPY" ? 'selected' : '' }}>{{ __('personal_details.jpy') }}</option>
                </select>
            </div>
        </div>

        <!-- RATES -->
        <div class="row">
            <div class="form-group col">
                <label for="translation_rate">{{ __('personal_details.translation_rate_source') }}</label>
                <textarea class="form-control {{ $errors->has('translation_rate') ? ' is-invalid' : '' }}" id="translation_rate" name="translation_rate" rows="1">@if(old('translation_rate')){{ old('translation_rate') }}@else{{ $user->personalDetails->translation_rate }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="editing_rate">{{ __('personal_details.editing_rate_source') }}</label>
                <textarea class="form-control {{ $errors->has('editing_rate') ? ' is-invalid' : '' }}" id="editing_rate" name="editing_rate" rows="1">@if(old('editing_rate')){{ old('editing_rate') }}@else{{ $user->personalDetails->editing_rate }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="transcription_rate">{{ __('personal_details.transcription_rate_minute') }}</label>
                <textarea class="form-control {{ $errors->has('transcription_rate') ? ' is-invalid' : '' }}" id="transcription_rate" name="transcription_rate" rows="1">@if(old('transcription_rate')){{ old('transcription_rate') }}@else{{ $user->personalDetails->transcription_rate }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="hourly_rate">{{ __('personal_details.rate_per_hour_rate') }}</label>
                <textarea class="form-control {{ $errors->has('hourly_rate') ? ' is-invalid' : '' }}" id="hourly_rate" name="hourly_rate" rows="1">@if(old('hourly_rate')){{ old('hourly_rate') }}@else{{ $user->personalDetails->hourly_rate }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <h2>{{ __('personal_details.bank_details_heading') }}</h2>
        </div>

        <!-- BANK DETAILS -->
        <div class="row">
            <div class="form-group col">
                <label for="account_name" class="required">{{ __('personal_details.account_name') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('account_name') ? ' is-invalid' : '' }}" id="account_name" name="account_name" rows="1" required @if($user->personalDetails->account_name) disabled @endif >@if(old('account_name')){{ old('account_name') }}@else{{ $user->personalDetails->account_name }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="account_number" class="required">{{ __('personal_details.account_number') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('account_number') ? ' is-invalid' : '' }}" id="account_number" name="account_number" rows="1" required @if($user->personalDetails->account_number) disabled @endif >@if(old('account_number')){{ old('account_number') }}@else{{ $user->personalDetails->account_number }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="bank_name" class="required">{{ __('personal_details.bank_name') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}" id="bank_name" name="bank_name" rows="1" required @if($user->personalDetails->bank_name) disabled @endif >@if(old('bank_name')){{ old('bank_name') }}@else{{ $user->personalDetails->bank_name }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="swift_code" class="required">{{ __('personal_details.swift_code') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('swift_code') ? ' is-invalid' : '' }}" id="swift_code" name="swift_code" rows="1" required @if($user->personalDetails->swift_code) disabled @endif >@if(old('swift_code')){{ old('swift_code') }}@else{{ $user->personalDetails->swift_code }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="bank_address" class="required">{{ __('personal_details.bank_address') }} <span>*</span></label>
                <textarea class="form-control {{ $errors->has('bank_address') ? ' is-invalid' : '' }}" id="bank_address" name="bank_address" rows="3" required @if($user->personalDetails->bank_address) disabled @endif >@if(old('bank_address')){{ old('bank_address') }}@else{{ $user->personalDetails->bank_address }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <p id="please-ensure-message">{{ __('personal_details.ensure_bank') }}</p>
        </div>

        <div class="row">
            <h2>{{ __('personal_details.cv_and_resume') }}</h2>
        </div>

        <!-- CV/PROFILE PICTURE UPLOAD -->
        <div id="cv_upload_section" class="row">
            <div class="col">
                <div class="form-group">
                    @if($user->hasCV)
                        <label for="cv_upload">{{ __('personal_details.cv_upload') }}</label>
                        <input type="file" name="cv_change" id="cv_upload" class="form-control-file {{ $errors->has('cv') ? ' is-invalid' : '' }}">
                        <p>{{ __('personal_details.currently') }}: {{ $user->personalDetails->cv->file_name }}</p>
                    @else
                        <label for="cv_upload" class="required">{{ __('personal_details.cv_upload') }} <span>*</span></label>
                        <input type="file" name="cv" id="cv_upload" class="form-control-file {{ $errors->has('cv') ? ' is-invalid' : '' }}" required>
                    @endif
                </div>

                <div class="form-group">
                    <label for="profile_picture_upload">{{ __('personal_details.pfp_upload') }}</label>
                    <input type="file" name="profile_picture" id="profile_picture_upload" class="form-control-file {{ $errors->has('profile_picture') ? ' is-invalid' : '' }}">
                    @if ($user->hasPFP)
                        <p>{{ __('personal_details.currently') }}: {{ $user->personalDetails->profilePicture->file_name }}</p>
                    @endif
                </div>

                <button id="btn_submit" class="btn btn-outline-light" type="submit">{{ __('personal_details.update_button') }}</button>
            </div>

            <div class="form-group col">
                <label for="user_profile_picture" class="label-block">{{ __('personal_details.current_pfp') }}:</label>
                <img id="user_profile_picture" src="{{ $user->getProfilePicturePath($user) }}" alt="{{ __('personal_details.your_pfp') }}">
                @if($user->hasPFP)
                    <button id="btn_remove_pfp" class="btn btn-outline-danger" onclick="document.getElementById('form_remove_pfp').submit(); event.preventDefault()">{{ __('personal_details.remove_button') }}</button>
                @endif
            </div>
        </div>
    </form>

    <form id="form_remove_pfp" method="POST" action="{{ '/profile_pictures/' . $user->personalDetails->profilePicture->id }}" enctype=multipart/form-data style="display: none;">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
    </form>
@stop
