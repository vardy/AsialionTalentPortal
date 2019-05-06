<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show($file_id)
    {
        $filePathExpected = '/talentportal/' . $file_id;
        if (!$file_id || !Storage::disk('s3')->exists($filePathExpected)) {
            abort(404);
        }

        // Check user has ownership of file or admin privileges.
        if(File::findOrFail($file_id)->invoice->user->id !== auth()->user()->id && auth()->user()->hasRole('admin')) {
            abort(404);
        }

        return response()->stream(function() use ($filePathExpected) {
            $stream = Storage::disk('s3')->readStream($filePathExpected);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Type'          => Storage::disk('s3')->mimeType($filePathExpected),
            'Content-Length'        => Storage::disk('s3')->size($filePathExpected),
            'Content-Disposition'   => 'attachment; filename="' . File::findOrFail($file_id)->file_name . '"',
            'Pragma'                => 'public',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
