@extends('layouts.admin')

@section('title', 'Admin Panel')

@section('active-home', 'active')

@section('content')
    <div class="panel-section top-section">
        <h1>Home</h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">Admin Panel</li>
            <li class="breadcrumb-item active">Home</li>
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
        <div class="row">
            <div class="col-lg-12">
                <h1>
                    Users
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <p>Below is a list of all users. Click on a username to view their personal details
                    and invoices.</p>

                <table class="table dataTable">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Creation Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="table-active">
                                <th scope="row"><a href="/admin/user/{{ $user->id }}"> {{ $user->name }} </a></th>
                                <td> {{ $user->email }} </td>
                                <td> {{ $user->created_at }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2>
                    Create new user
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <p><a href="/admin/register">Click here to go to registration page.</a></p>
            </div>
        </div>
    </div>

    <div class="panel-section">
        <div class="row">
            <div class="col-lg-12">
                <h1>
                    Invoices
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <p>Below is a list of all invoices. Sort table headings to see chronologically. For
                    individual users' invoices, select a user from the 'Users' table. Click on an invoice
                number to see more details. Click on a user's name to see the user's profile and other invoices.</p>

                <table class="table dataTable">
                    <thead>
                    <tr>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">User</th>
                        <th scope="col">Total</th>
                        <th scope="col">Num of Files</th>
                        <th scope="col">Num of Purchase Orders</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($invoices as $invoice)
                        <tr class="table-active">
                            <th scope="row"><a href="/admin/invoice/{{ $invoice->id }}"> {{ $invoice->invoice_number }} </a></th>
                            <th scope="row"><a href="/admin/user/{{ $user->id }}"> {{ $invoice->user->name }} </a></th>
                            <td> {{ $invoice->total }} </td>
                            <td> {{ $invoice->num_of_files }} </td>
                            <td> {{ $invoice->num_of_pos }} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="panel-section">
        <div class="row">
            <div class="col-lg-12">
                <h1>
                    Update NDA
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <p>Upload a new PDF file to change the NDA on the '/nda' page.</p>

                <form id="form_nda" method="POST" action="{{ route('update_nda') }}" enctype=multipart/form-data>
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label class="label-block">NDA File:</label>
                        <input type="file" name="nda" required>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop