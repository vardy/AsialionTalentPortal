@extends('layouts.master')

@section('title', 'Invoice ' . $invoice_id)

@section('content')
    <!--
    Show invoice number and total value
    Show table of details for purchase orders
    Show table of details for files
    -->

    <h1>Invoice {{ $invoice->invoice_number }}</h1>
@stop