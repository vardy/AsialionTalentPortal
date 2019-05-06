<?php

namespace App\Http\Controllers;

use App\ProfilePicture;
use Illuminate\Http\Request;

class ProfilePictureController extends Controller
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
     * @param  \App\ProfilePicture  $profilePicture
     * @return \Illuminate\Http\Response
     */
    public function show(ProfilePicture $profilePicture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProfilePicture  $profilePicture
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfilePicture $profilePicture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProfilePicture  $profilePicture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfilePicture $profilePicture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProfilePicture  $profilePicture
     * @return \Illuminate\Http\Response
     */
    public function destroy($pfp_id)
    {
        $user = ProfilePicture::findOrFail($pfp_id)->personalDetails->user;

        $user->hasPFP = 0;
        $user->save();

        $user->personalDetails->profilePicture->file_name = null;
        $user->personalDetails->profilePicture->save();

        $path = storage_path() . '/app/public/user_data/profile_pictures/' . $user->personalDetails->profilePicture->id;;
        unlink($path); // Removes PFP file

        return redirect(route('personal_details'))->with([
            'success-message' => 'Profile picture successfully removed.'
        ]);
    }
}
