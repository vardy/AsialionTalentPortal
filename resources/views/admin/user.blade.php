@extends('layouts.admin')

@section('title', 'Invoice')

@section('active-home', 'active')

@section('content')
    <div class="panel-section top-section">
        <h1>Home</h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">Admin Panel</li>
            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
            <li class="breadcrumb-item active">User: {{ $user->name }}</li>
        </ol>
    </div>

    <div class="panel-section">
        <h1>Talent's Account Details</h1>

        <table id="account_details_table" class="table table-striped table-borderless">
            <tbody>
                <tr>
                    <th scope="row">Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th scope="row">Created At</th>
                    <td>{{ $user->created_at }}</td>
                </tr>
                <tr>
                    <th scope="row">ID</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th scope="row">Has CV?</th>
                    <td>{{ $user->hasCV }}</td>
                </tr>
                <tr>
                    <th scope="row">Has Profile Picture?</th>
                    <td>{{ $user->hasPFP }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="panel-section">
        <h1>Talent's Invoices</h1>

        <table class="table dataTable">
            <thead>
                <tr>
                    <th scope="col">Invoice Number</th>
                    <th scope="col">Total</th>
                    <th scope="col">Num of Purchase Orders</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->invoices as $invoice)
                    <tr>
                        <th scope="row"><a href="/admin/invoice/{{ $invoice->id }}">{{ $invoice->invoice_number }}</a></th>
                        <td>{{ $invoice->total }}</td>
                        <td>{{ $invoice->num_of_pos }}</td>
                        <td>{{ $invoice->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="panel-section">
        <h1>Talent's CV</h1>

        <div id="user_cv_details">
            @if ($user->hasCV)
                <p><a href="/cvs/{{ $user->personalDetails->cv->id }}">Click here to download the user's CV.</a></p>
                <p>File name: {{ $user->personalDetails->cv->file_name }}</p>
            @else
                <p>This user has not uploaded a CV.</p>
            @endif
        </div>
    </div>

    <div class="panel-section">
        <h1>Talent's Personal Details</h1>

        <img id="user_profile_picture" src="{{ $user->getProfilePicturePath($user) }}" alt="User's profile picture.">

        <table id="user_personal_details" class="table table-striped table-borderless">
            <tbody>
            @foreach ($user->personalDetails->getAttributes() as $key => $value)
                @if($key !== 'id')
                    @if($key !== 'user_id')
                        <tr>
                            <th scope="row">{{ $key }}</th>
                            <td>{{ $value }}</td>
                        </tr>
                    @endif
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    @if(!\App\User::findOrFail($user->id)->hasRole('admin'))
        <div class="panel-section">
            <h1>Delete User Account</h1>

            <form id="form_delete" method="POST" action="/user/{{ $user->id }}" enctype=multipart/form-data>
                {{ method_field('DELETE') }}
                {{ csrf_field() }}

                <button id="btn_account_delete" class="btn btn-outline-danger" onclick="if(confirm('Are you sure you want to delete this user?')){parentNode.submit()}">Delete User</button>
            </form>
        </div>
    @endif
@stop