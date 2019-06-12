@extends('layouts.master')

@section('title', 'NDA')

@section('currently_selected_nda', 'currently-selected')

@section('imports')
    <link href="{{ mix('css/nda.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
@stop

@section('content')
    <div id="pdf_viewer"></div>

    <div id="pdf_download_section">
        <a href="/storage/files/NDA.pdf" download><button class="btn-dark" id="btn_download">{{ __('nda.download_button') }}</button></a>
    </div>

    <script>
        var options = {
            fallbackLink: '<p>This browser does not support viewing PDFs. Please download the PDF to view it: <a href="{{ storage_path('files/NDA.pdf') }}">Download PDF</a></p>'
        };

        PDFObject.embed("/storage/files/NDA.pdf", "#pdf_viewer", options);
    </script>
@stop
