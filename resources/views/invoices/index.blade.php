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
                    <th scope="row"><a href="/invoices/{{ $invoice->id }}"> {{ $invoice->invoice_number }} </a></th>
                    <td> THB {{ $invoice->total }} </td>
                    <td> {{ $invoice->num_of_pos }} </td>
                    <td> {{ $invoice->num_of_files }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h1 id="new_invoice_header">New Invoice</h1>

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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="form_create" method="POST" action="{{ route('invoices') }}" enctype=multipart/form-data>
        {{ csrf_field() }}

        <div class="row">
            <!-- Invoice number section -->
            <div class="col">
                <label for="invoice_number">Invoice number (optional)</label>
                <textarea class="form-control {{ $errors->has('invoice_number') ? ' is-invalid' : '' }}" id="invoice_number" name="invoice_number" rows="1">{{ old('invoice_number') }}</textarea>
                <small id="labelHelp" class="form-text text-muted">Max 255 characters.</small>
            </div>

            <!-- File upload section -->
            <div class="col">
                <label for="upload_file">Attach files</label>
                <input type="file" name="files[]" class="form-control-file" multiple>
                <small id="labelHelp" class="form-text text-muted">You may attach multiple files at once.</small>
            </div>
        </div>

        <!-- Purchase order section -->
        <div class="form-group">
            <label for="btn_add_purchase_order">Purchase orders</label>
            <button id="btn_add_purchase_order" class="btn-info form-control">Add purchase order</button>

            <table id="dynamic_field">
            </table>
        </div>

        <!-- NDA Waiver secction -->
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="ndaCheck" name="ndaCheck" required>
                <label class="form-check-label" for="ndaCheck">I have read and accept <a href="{{ route('nda') }}">the NDA agreement</a>.</label>
            </div>
        </div>

        <!-- Submit button -->
        <div class="form-group">
            <button class="btn-success" type="submit" >Submit</button>
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
                    "                        <button class=\"btn-danger btn_remove\" id=" + i + ">Delete</button>\n" +
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