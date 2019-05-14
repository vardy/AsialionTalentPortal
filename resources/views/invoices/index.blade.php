@extends('layouts.master')

@section('title', 'Invoices')

@section('imports')
    <link href="{{ mix('css/invoices.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
@stop

@section('content')
    <h1 id="new_invoice_header">New Invoice</h1>

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

    <p id="invoice_flavour">
        Welcome to ASIAL10N's secure file server. This is where you submit your payment requests and
        upload your invoices to be processed. Please accumulate all jobs into one invoice at the end of each month for submission. DO NOT submit your invoice
        prior to completion of your assignment.
    </p>

    <p id="upload-prologue">Payment depends on your delivery of high-quality work by the agreed
        deadline.</p>

    <form id="form_create" method="POST" action="{{ route('invoices') }}" enctype=multipart/form-data>
        {{ csrf_field() }}

        <!-- Purchase order section -->
        <div class="form-group">
            <table id="dynamic_field">
                <tr class="dynamic-row" id="dynamic-row-1">
                    <td>
                        <label for="po1_number">Purchase order number</label>
                        <textarea class="form-control po_field" id="po1_number" name="po_number[]" rows="1" required></textarea>
                    </td>
                    <td>
                        <label for="po1_description">Description</label>
                        <textarea class="form-control po_field" id="po1_description" name="po_description[]" rows="1" required></textarea>
                    </td>
                    <td>
                        <label for="po1_value">Value</label>
                        <input type="number" class="form-control po_field" id="po1_value" name="po_value[]" step="0.01" value="0.00" placeholder="0.00" required/>
                    </td>
                    <td class="col_btn_delete">
                        <button class="btn btn-outline-danger btn_remove" id="1">Remove</button>
                    </td>
                </tr>
                <tr class="dynamic-row" id="dynamic-row-2">
                    <td>
                        <label for="po2_number">Purchase order number</label>
                        <textarea class="form-control po_field" id="po2_number" name="po_number[]" rows="1" required></textarea>
                    </td>
                    <td>
                        <label for="po2_description">Description</label>
                        <textarea class="form-control po_field" id="po2_description" name="po_description[]" rows="1" required></textarea>
                    </td>
                    <td>
                        <label for="po2_value">Value</label>
                        <input type="number" class="form-control po_field" id="po2_value" name="po_value[]" step="0.01" value="0.00" placeholder="0.00" required/>
                    </td>
                    <td class="col_btn_delete">
                        <button class="btn btn-outline-danger btn_remove" id="2">Remove</button>
                    </td>
                </tr>
                <tr class="dynamic-row" id="dynamic-row-3">
                    <td>
                        <label for="po3_number">Purchase order number</label>
                        <textarea class="form-control po_field" id="po3_number" name="po_number[]" rows="1" required></textarea>
                    </td>
                    <td>
                        <label for="po3_description">Description</label>
                        <textarea class="form-control po_field" id="po3_description" name="po_description[]" rows="1" required></textarea>
                    </td>
                    <td>
                        <label for="po3_value">Value</label>
                        <input type="number" class="form-control po_field" id="po3_value" name="po_value[]" step="0.01" value="0.00" placeholder="0.00" required/>
                    </td>
                    <td class="col_btn_delete">
                        <button class="btn btn-outline-danger btn_remove" id="3">Remove</button>
                    </td>
                </tr>
            </table>
        </div>

        <button id="btn_add_purchase_order" class="btn btn-outline-light form-control">Add purchase order <i class="fas fa-plus"></i></button>

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
                <input type="file" name="file" class="form-control-file">
            </div>
        </div>

        <!-- NDA Waiver secction -->
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="ndaCheck" name="ndaCheck" required>
                <label class="form-check-label" for="ndaCheck">I have read and accept the terms of the <a href="{{ route('nda') }}">NDA agreement</a>.</label>
            </div>
        </div>

        <!-- Submit button -->
        <div class="form-group">
            <button class="btn btn-outline-light" type="submit" >Submit</button>
        </div>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            var i = 3;

            $('#btn_add_purchase_order').click(function(event) {
                event.preventDefault();

                i++;
                $('#dynamic_field').append("<tr class=\"dynamic-row\" id=\"dynamic-row-" + i + "\">\n" +
                    "                    <td>\n" +
                    "                        <label for=\"po" + i + "_number\">Purchase order number</label>\n" +
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
                    "                        <button class=\"btn btn-outline-danger btn_remove\" id=" + i + ">Remove</button>\n" +
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