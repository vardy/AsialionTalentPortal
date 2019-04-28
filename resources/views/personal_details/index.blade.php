@extends('layouts.master')

@section('title', 'Personal Details')

@section('imports')
    <link href="{{ mix('css/personal_details.css') }}" rel="stylesheet">
@stop

@section('content')
    <!-- Form, 'update' button, populate with current values -->
    <!-- Fill text fields with {{ old('invoice_number') }} if exists, else fill with current value if not null-->
    <!-- class="form-control {{ $errors->has('invoice_number') ? ' is-invalid' : '' }}" -->
    <!-- <small id="labelHelpTest1" class="form-text text-muted">Max 255 characters.</small> -->

    <h1>Personal Details</h1>

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

        <div class="row">
            <div class="form-group col">
                <label for="country_of_residence" class="required">Country of Residence <span>*</span></label>
                <select class="form-group  {{ $errors->has('country_of_residence') ? ' is-invalid' : '' }}" id="country_of_residence" name="country_of_residence">
                    @foreach($countries as $country)
                        <option @if($country->name == $user->personalDetails->country_of_residence) selected @endif>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- UPLOAD FILE -->

        <div class="form-group row">
            <button id="btn_submit" class="btn-success" type="submit">Update</button>
        </div>
    </form>
@stop