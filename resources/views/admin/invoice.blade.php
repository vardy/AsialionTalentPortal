@extends('layouts.admin')

@section('title', 'Invoice')

@section('active-home', 'active')

@section('content')
    <div class="panel-section top-section">
        <h1>Home</h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">Admin Panel</li>
            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="/admin/user/{{ $invoice->user->id }}">User '{{ $invoice->user->name }}'</a></li>
            <li class="breadcrumb-item active">Invoice: {{ $invoice->invoice_number }}</li>
        </ol>
    </div>

    <div class="panel-section">
        <div id="invoice_stats">
            <p>Submitter: <a href="/admin/user/{{ $invoice->user->id }}">{{ $invoice->user->name }}</a></p>
            <p>Invoice number: {{ $invoice->invoice_number }}</p>
            <p>Total (from purchase orders): THB {{ $invoice->total }}</p>
            <p>Number of purchase orders: {{ $invoice->num_of_pos }}</p>
            <p>File attached: @if($invoice->file) Yes @else No @endif</p>
        </div>
    </div>

    <div class="panel-section">
        <h2>File</h2>

        <table class="table dataTable">
            <thead>
                <tr>
                    <th scope="col">File Name</th>
                    <th scope="col">File Size (KB)</th>
                    <th scope="col">File Type</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody>
                @if($invoice->file)
                    <tr class="table-active">
                        <th scope="row"><a href="/files/{{ $invoice->file->id }}"> {{ $invoice->file->file_name }} </a></th>
                        <td> {{ $invoice->file->file_size }} </td>
                        <td> {{ $invoice->file->file_mime }} </td>
                        <td> {{ $invoice->file->created_at }} </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="panel-section">
        <h2>Purchase Orders</h2>

        <table class="table dataTable">
            <thead>
            <tr>
                <th scope="col">Order Number</th>
                <th scope="col">Description</th>
                <th scope="col">Value (THB)</th>
                <th scope="col">Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->purchase_orders as $po)
                <tr class="table-active">
                    <td> {{ $po->po_number }} </td>
                    <td> {{ $po->description }} </td>
                    <td> {{ $po->value }} </td>
                    <td> {{ $po->created_at }} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="panel-section">
        <h1>Delete</h1>

        <form id="form_delete" method="POST" action="{{ route('invoices') }}/{{ $invoice->id }}" enctype=multipart/form-data>
            {{ method_field('DELETE') }}
            {{ csrf_field() }}

            <button id="btn_invoice_delete" class="btn btn-outline-danger" onclick="parentNode.submit();">Delete Invoice</button>
        </form>
    </div>
@endsection