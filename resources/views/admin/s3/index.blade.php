@extends('layouts.admin')

@section('title', 'S3')

@section('active-s3', 'active')

@section('content')
    <div class="panel-section top-section">
        <h1>Home</h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">Admin Panel</li>
            <li class="breadcrumb-item active">File Management</li>
        </ol>
    </div>

    <div class="panel-section">
        <h1>All Files</h1>

        @if (count($s3_files) > 0)
            <ul>
                @foreach ($s3_files as $file)
                    <li class="file-list-item">{{ $file }}</li>
                @endforeach
            </ul>
        @else
            <p>There are no files in the S3 database.</p>
        @endif
    </div>

    <div class="panel-section">
        <h1>Controls</h1>

        <button id="btn_purge_all" class="btn btn-outline-danger">Purge All</button>
        <button id="btn_smart_purge" class="btn btn-outline-danger">Smart Purge</button>
    </div>

    <form id="purge_all">

    </form>

    <form id="smart_purge">

    </form>
@endsection