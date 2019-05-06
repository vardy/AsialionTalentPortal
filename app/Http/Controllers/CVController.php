<?php

namespace App\Http\Controllers;

use App\CV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CVController extends Controller
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
     * @param  \App\CV  $cV
     * @return \Illuminate\Http\Response
     */
    public function show($cv_id, CV $cV)
    {
        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        $filePathExpected = '/talentportal/' . $cv_id;
        if (!$cv_id || !Storage::disk('s3')->exists($filePathExpected)) {
            abort(404);
        }

        // Check user has ownership of file or admin privileges.
        if(!auth()->user()->hasRole('admin')) {
            if(CV::findOrFail($cv_id)->personalDetails->user->id !== auth()->user()->id) {
                abort(404);
            }
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
            'Content-Disposition'   => 'attachment; filename="' . CV::findOrFail($cv_id)->file_name . '"',
            'Pragma'                => 'public',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CV  $cV
     * @return \Illuminate\Http\Response
     */
    public function edit(CV $cV)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CV  $cV
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CV $cV)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CV  $cV
     * @return \Illuminate\Http\Response
     */
    public function destroy(CV $cV)
    {
        //
    }
}
