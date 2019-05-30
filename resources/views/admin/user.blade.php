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
        <h1>User Account Permissions</h1>

        <ul class="list-group">
            @if($roles->isNotEmpty())
                @foreach($roles as $role)
                    <li class="list-group-item"><a>{{ $role->name }}</a><button class="btn btn-outline-danger btn-role-remove" onclick="document.getElementById('form-delete-' + '{{ $role->name }}').submit()"><a>Remove</a></button></li>
                @endforeach
            @else
                <li class="list-group-item">This user has no roles</li>
            @endif
        </ul>

        <h2>Add roles to user</h2>

        <p>Click on a role to add it to the user</p>

        <ul class="list-group-horizontal static-role-list">
            @foreach (DB::table('roles')->select('name')->get()->toArray() as $role)
                <li class="list-group-item static-role-list-item" onclick="document.getElementById('form-' + '{{ $role->name}}').submit()">{{ $role->name }}</li>
            @endforeach
        </ul>
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

    <div class="panel-section">
        <h1>Update user's password</h1>

        <form id="form-update-password" method="POST" action="/admin/user/{{ $user->id }}/password"> <!-- Patch user's password. Validate password is confirmed. Use two text inputs. -->
            {{ method_field('PATCH') }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

                <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <button class="btn btn-outline-success" onclick="parentNode.parentNode.submit()"><a>Update</a></button>
            </div>
        </form>
    </div>

    @if(auth()->user()->hasRole('admin'))
        <div class="panel-section">
            <h1>Delete User Account</h1>

            <form id="form_delete" method="POST" action="/user/{{ $user->id }}" enctype=multipart/form-data>
                {{ method_field('DELETE') }}
                {{ csrf_field() }}

                <button id="btn_account_delete" class="btn btn-outline-danger" onclick="if(confirm('Are you sure you want to delete this user?')){parentNode.submit()}">Delete User</button>
            </form>
        </div>
    @endif

    <form id="form-admin" method="POST" action="/admin/user/{{ $user->id }}/roles/admin" style="display: none">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
    </form>


    <form id="form-user" method="POST" action="/admin/user/{{ $user->id }}/roles/user" style="display: none">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
    </form>

    <form id="form-delete-admin" method="POST" action="/admin/user/{{ $user->id }}/roles/admin" style="display: none">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
    </form>

    <form id="form-delete-user" method="POST" action="/admin/user/{{ $user->id }}/roles/user" style="display: none">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
    </form>
@stop
