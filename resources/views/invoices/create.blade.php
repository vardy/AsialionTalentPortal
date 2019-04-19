@extends('layouts.master')

@section('title', 'Invoices')

@section('imports')
    <link href="{{ mix('css/invoices.css') }}" rel="stylesheet">
@stop

@section('content')
    <h1>Invoices</h1>

    <p id="invoice_flavour">
        Welcome to ASIAL10N's secure file server. This is where you submit your payment requests and
        upload your invoices to be processed.
    </p>

    <!--
        Table to display invoices
    -->
    <table class="table dataTable">
        <thead>
            <tr>
                <th scope="col">Invoice Number</th>
                <th scope="col">Total</th>
                <th scope="col"># of POs</th>
                <th scope="col"># of Files</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr class="table-active">
                    <th scope="row"><a href="#"> {{ $invoice->invoice_number }} </a></th>
                    <td> THB {{ $invoice->total }} </td>
                    <td> {{ $invoice->num_of_pos }} </td>
                    <td> {{ $invoice->num_of_files }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!--

        Form:
          Invoice number (optional)
          PO section (click to add another PO)
            PO Number
            Description
            Value
          Display: total value (sum of PO section values)
          Attach files
          Submit button
    -->
@stop