@extends('layouts.master')

@section('title', 'Invoice ' . $invoice_id)

@section('imports')
    <link href="{{ mix('css/invoices.css') }}" rel="stylesheet">
@stop

@section('content')
    <!--
    Form to delete invoice
    -->

    <h1>Invoice {{ $invoice->invoice_number }}</h1>

    <div id="invoice_stats">
        <p>Total (from purchase orders): THB {{ $invoice->total }}</p>
        <p>Number of purchase orders: {{ $invoice->num_of_pos }}</p>
    </div>

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

    <form id="form_delete" method="POST" action="{{ route('invoices') }}/{{ $invoice->id }}" enctype=multipart/form-data>
        {{ method_field('DELETE') }}
        {{ csrf_field() }}

        <button class="btn btn-outline-danger" onclick="parentNode.submit();">Delete Invoice</button>
    </form>
@stop