@extends('layouts.master')

@section('title', 'Personal Details')

@section('imports')
    <link href="{{ mix('css/personal_details.css') }}" rel="stylesheet">
@stop

@section('content')
    <h1>Personal Details</h1>

    <p id="required_flavour_text" class="required"><span>*</span> Required</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="form_personal_details" method="POST" action="{{ route('personal_details') }}" enctype=multipart/form-data>
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <!-- Basic user details -->
        <div class="row">
            <div class="form-group col">
                <label for="first_name" class="required">First/Given Name <span>*</span></label>
                <textarea class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" id="first_name" name="first_name" rows="1" required>@if(old('first_name')){{ old('first_name') }}@else{{ $user->personalDetails->first_name }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="last_name" class="required">Last/Family Name <span>*</span></label>
                <textarea class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" id="last_name" name="last_name" rows="1" required>@if(old('last_name')){{ old('last_name') }}@else{{ $user->personalDetails->last_name }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="email" class="required">Email <span>*</span></label>
                <textarea class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" rows="1" required>@if(old('email')){{ old('email') }}@else{{ $user->personalDetails->email }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="skype_id">Skype ID</label>
                <textarea class="form-control {{ $errors->has('skype_id') ? ' is-invalid' : '' }}" id="skype_id" name="skype_id" rows="1">@if(old('skype_id')){{ old('skype_id') }}@else{{ $user->personalDetails->skype_id }}@endif</textarea>
            </div>
        </div>

        <!-- Country of residence -->
        <div class="row">
            <div class="form-group col">
                <label for="country_of_residence" class="label-block required">Country of Residence <span>*</span></label>
                <select class="form-group {{ $errors->has('country_of_residence') ? ' is-invalid' : '' }}" id="country_of_residence" name="country_of_residence">
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
                <label for="mobile_number" class="required">Mobile Phone Number <span>*</span></label>
                <textarea class="form-control {{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" id="mobile_number" name="mobile_number" rows="1" required>@if(old('mobile_number')){{ old('mobile_number') }}@else{{ $user->personalDetails->mobile_number }}@endif</textarea>
                <small id="mobile_number_small_text" class="form-text text-muted">Linguists will be notified via mobile for new jobs and accepting POs.</small>
            </div>

            <div class="form-group col">
                <label for="home_number">Home Phone Number</label>
                <textarea class="form-control {{ $errors->has('home_number') ? ' is-invalid' : '' }}" id="home_number" name="home_number" rows="1">@if(old('home_number')){{ old('home_number') }}@else{{ $user->personalDetails->home_number }}@endif</textarea>
            </div>
        </div>

        <!-- Education/Experience -->
        <div class="row">
            <div class="form-group col">
                <label for="highest_education" class="required">Highest Education <span>*</span></label>
                <textarea class="form-control {{ $errors->has('highest_education') ? ' is-invalid' : '' }}" id="highest_education" name="highest_education" rows="3" required>@if(old('highest_education')){{ old('highest_education') }}@else{{ $user->personalDetails->highest_education }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="professional_experience" class="required">Professional Experience <span>*</span></label>
                <textarea class="form-control {{ $errors->has('professional_experience') ? ' is-invalid' : '' }}" id="professional_experience" name="professional_experience" rows="3" required>@if(old('professional_experience')){{ old('professional_experience') }}@else{{ $user->personalDetails->professional_experience }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="industry_experience" class="required">Industry Experience <span>*</span></label>
                <textarea class="form-control {{ $errors->has('industry_experience') ? ' is-invalid' : '' }}" id="industry_experience" name="industry_experience" rows="3" required>@if(old('industry_experience')){{ old('industry_experience') }}@else{{ $user->personalDetails->industry_experience }}@endif</textarea>
                <small id="industry_experience_small_text" class="form-text text-muted">For example: Surveys, IT, Marketing, Transcreation, Transcription, E-Commerce, Engineering, Gaming, Finance, etc.</small>
            </div>

            <div class="form-group col">
                <label for="language_pairs" class="required">Language Pair(s) <span>*</span></label>
                <textarea class="form-control {{ $errors->has('language_pairs') ? ' is-invalid' : '' }}" id="language_pairs" name="language_pairs" rows="3" required>@if(old('language_pairs')){{ old('language_pairs') }}@else{{ $user->personalDetails->language_pairs }}@endif</textarea>
                <small id="language_pairs_small_text" class="form-text text-muted">For example: EN-JP, TH-EN, CH-TH, etc</small>
            </div>
        </div>

        <!-- Non-required extra info. Tools and turnaround -->
        <div class="row">
            <div class="form-group col">
                <label for="tools">Tools</label>
                <textarea class="form-control {{ $errors->has('tools') ? ' is-invalid' : '' }}" id="tools" name="tools" rows="2">@if(old('tools')){{ old('tools') }}@else{{ $user->personalDetails->tools }}@endif</textarea>
                <small id="tools_small_text" class="form-text text-muted">For example: SDL Studio, Trados, Idiom, Helium, LocStudio, Passolo, MS Leaf/Fabric, MemoQ, Oddjob/Memsource, Wordbee, Smartling, Wordfast, GTT etc.</small>
            </div>

            <div class="form-group col">
                <label for="turnaround_per_day">Turnaround per day (number of words)</label>
                <textarea class="form-control {{ $errors->has('turnaround_per_day') ? ' is-invalid' : '' }}" id="turnaround_per_day" name="turnaround_per_day" rows="1">@if(old('turnaround_per_day')){{ old('turnaround_per_day') }}@else{{ $user->personalDetails->turnaround_per_day }}@endif</textarea>
            </div>
        </div>

        <!-- Currency -->
        <div class="row">
            <div class="form-group col">
                <label id="currency_used_label" for="currency_used" class="label-block required">Currency Used Below <span>*</span></label>
                <select class="form-group {{ $errors->has('currency_used') ? ' is-invalid' : '' }}" id="currency_used" name="currency_used" required>
                    <option selected>USD</option>
                    <option {{ $user->personalDetails->currency_used == "SGD" ? 'selected' : '' }}>SGD</option>
                    <option {{ $user->personalDetails->currency_used == "THB" ? 'selected' : '' }}>THB</option>
                    <option {{ $user->personalDetails->currency_used == "RMB" ? 'selected' : '' }}>RMB</option>
                    <option {{ $user->personalDetails->currency_used == "JPY" ? 'selected' : '' }}>JPY</option>
                </select>
            </div>
        </div>

        <!-- PERMANENT POSITIONS -->
        <h2>For Permanent Positions</h2>

        <div class="row">
            <div class="form-group col">
                <label for="latest_remuneration">Current/Last Remuneration</label>
                <textarea class="form-control {{ $errors->has('latest_remuneration') ? ' is-invalid' : '' }}" id="latest_remuneration" name="latest_remuneration" rows="1">@if(old('latest_remuneration')){{ old('latest_remuneration') }}@else{{ $user->personalDetails->latest_remuneration }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="expected_remuneration">Expected Remuneration</label>
                <textarea class="form-control {{ $errors->has('expected_remuneration') ? ' is-invalid' : '' }}" id="expected_remuneration" name="expected_remuneration" rows="1">@if(old('expected_remuneration')){{ old('expected_remuneration') }}@else{{ $user->personalDetails->expected_remuneration }}@endif</textarea>
            </div>
        </div>

        <!-- FREELANCER POSITIONS -->
        <h2 id="for_freelancers_header">For Freelancers</h2>

        <div class="row">
            <div class="form-group col">
                <label for="translation_rate">Translation Rate Per Source Word</label>
                <textarea class="form-control {{ $errors->has('translation_rate') ? ' is-invalid' : '' }}" id="translation_rate" name="translation_rate" rows="1">@if(old('translation_rate')){{ old('translation_rate') }}@else{{ $user->personalDetails->translation_rate }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="editing_rate">Editing Rate Per Source Word</label>
                <textarea class="form-control {{ $errors->has('editing_rate') ? ' is-invalid' : '' }}" id="editing_rate" name="editing_rate" rows="1">@if(old('editing_rate')){{ old('editing_rate') }}@else{{ $user->personalDetails->editing_rate }}@endif</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="transcription_rate">Transcription Rate Per Minute (if experienced)</label>
                <textarea class="form-control {{ $errors->has('transcription_rate') ? ' is-invalid' : '' }}" id="transcription_rate" name="transcription_rate" rows="1">@if(old('transcription_rate')){{ old('transcription_rate') }}@else{{ $user->personalDetails->transcription_rate }}@endif</textarea>
            </div>

            <div class="form-group col">
                <label for="hourly_rate">Rate Per Hour Rate</label>
                <textarea class="form-control {{ $errors->has('hourly_rate') ? ' is-invalid' : '' }}" id="hourly_rate" name="hourly_rate" rows="1">@if(old('hourly_rate')){{ old('hourly_rate') }}@else{{ $user->personalDetails->hourly_rate }}@endif</textarea>
            </div>
        </div>

        <!-- CV UPLOAD -->
        <div id="cv_upload_section" class="row">
            <div class="form-group col">
                <label for="cv_upload" class="required">CV or Résumé (PDF or Docx) <span>*</span></label>
                <input type="file" name="cv" class="form-control-file" required>
            </div>
        </div>

        <!-- SUBMIT -->
        <div class="form-group row">
            <button id="btn_submit" class="btn-success" type="submit">Update</button>
        </div>
    </form>
@stop