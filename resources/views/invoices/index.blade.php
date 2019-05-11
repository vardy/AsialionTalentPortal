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

    <!--
        Table to display invoices
    <table class="table dataTable">
        <thead>
            <tr>
                <th scope="col">Invoice Number</th>
                <th scope="col">Total</th>
                <th scope="col"># of POs</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr class="table-active">
                    <th scope="row"><a href="/invoices/{{ $invoice->id }}"> {{ $invoice->invoice_number }} </a></th>
                    <td> THB {{ $invoice->total }} </td>
                    <td> {{ $invoice->num_of_pos }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>-->

    <h1 id="new_invoice_header">New Invoice</h1>

    <form id="form_create" method="POST" action="{{ route('invoices') }}" enctype=multipart/form-data>
        {{ csrf_field() }}

        <div class="row">
            <!-- Invoice number section -->
            <div class="col">
                <label for="invoice_number">Invoice number</label>
                <textarea class="form-control {{ $errors->has('invoice_number') ? ' is-invalid' : '' }}" id="invoice_number" name="invoice_number" rows="1" required>{{ old('invoice_number') }}</textarea>
                <small id="labelHelp" class="form-text text-muted">Max 255 characters.</small>
            </div>

            <!-- File upload section -->
            <div class="col">
                <label for="upload_file">Attach file</label>
                <input type="file" name="file" class="form-control-file" multiple>
                <small id="labelHelp" class="form-text text-muted">You may attach one file at a time.</small>
            </div>
        </div>

        <!-- Purchase order section -->
        <div class="form-group">
            <label for="btn_add_purchase_order">Purchase orders</label>
            <button id="btn_add_purchase_order" class="btn btn-outline-info form-control">Add purchase order</button>

            <table id="dynamic_field">
            </table>
        </div>

        <!-- NDA Waiver secction -->
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="ndaCheck" name="ndaCheck" required>
                <label class="form-check-label" for="ndaCheck">I have read and accept the <a href="{{ route('nda') }}">NDA agreement</a>.</label>
            </div>
        </div>

        <!-- Submit button -->
        <div class="form-group">
            <button class="btn btn-outline-light" type="submit" >Submit</button>
        </div>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            var i = 0;

            $('#btn_add_purchase_order').click(function(event) {
                event.preventDefault();

                i++;
                $('#dynamic_field').append("<tr class=\"dynamic-row\" id=\"dynamic-row-" + i + "\">\n" +
                    "                    <td>\n" +
                    "                        <label for=\"po" + i + "_number\">Order number</label>\n" +
                    "                        <textarea class=\"form-control po_field\" id=\"po" + i + "_number\" name=\"po_number[]\" rows=\"1\" required></textarea>\n" +
                    "                    </td>\n" +
                    "                    <td>\n" +
                    "                        <label for=\"po" + i + "_description\">Description</label>\n" +
                    "                        <textarea class=\"form-control po_field\" id=\"po" + i + "_description\" name=\"po_description[]\" rows=\"1\" required></textarea>\n" +
                    "                    </td>\n" +
                    "                    <td>\n" +
                    "                        <label for=\"po" + i + "_value\">Value</label>\n" +
                    "                        <input type=\"number\" class=\"form-control po_field\" id=\"po" + i + "_value\" name=\"po_value[]\" step=\"0.01\" value=\"0.00\" placeholder=\"0.00\" required/>\n" +
                    "                    </td>\n" +
                    "                    <td class=\"col_btn_delete\">\n" +
                    "                        <button class=\"btn btn-outline-danger btn_remove\" id=" + i + ">Delete</button>\n" +
                    "                    </td>\n" +
                    "                </tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#dynamic-row-'+ button_id).remove();
            });
        });
    </script>
@stop