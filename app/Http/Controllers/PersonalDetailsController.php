<?php

namespace App\Http\Controllers;

use App\CV;
use App\PersonalDetails;
use App\ProfilePicture;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager as Image;
use League\Flysystem\Filesystem;

class PersonalDetailsController extends Controller
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
        return view('personal_details.index', [
            'user' => auth()->user(),
            'countries' => \Countries::all()
        ]);
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
     * @param  \App\PersonalDetails  $personalDetails
     * @return \Illuminate\Http\Response
     */
    public function show(PersonalDetails $personalDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PersonalDetails  $personalDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(PersonalDetails $personalDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PersonalDetails  $personalDetails
     * @return \Illuminate\Http\Response
     */
    public function update($user_id, Request $request)
    {
        // Validate form inputs
        // Persist _changes_ to database
        request()->validate([
            'first_name' => ['required', 'max:1000'],
            'last_name' => ['required', 'max:1000'],
            'email' => ['required', 'email', 'max:1000'],
            'skype_id' => ['max:1000'],

            'country_of_residence' => ['required'],
            'mobile_number' => ['required', 'max:1000'],
            'home_number' => ['max:1000'],

            'highest_education' => ['required', 'max:1000'],
            'professional_experience' => ['required', 'max:2000'],
            'industry_specialization' => ['required', 'max:2000'],
            'language_pairs' => ['required', 'max:1000'],

            'tools' => ['max:2000'],
            'turnaround_per_day' => ['max:2000'],
            'currency_used' => ['required'],

            'latest_remuneration' => ['max:1000'],
            'expected_remuneration'  => ['max:1000'],

            'translation_rate' => ['max:1000'],
            'editing_rate' => ['max:1000'],
            'transcription_rate' => ['max:1000'],
            'hourly_rate' => ['max:1000'],

            'profile_picture' => ['max:500000', 'mimes:jpg,jpeg,png'] // Max: 0.5GB (500MB)
        ]);

        if($request->cv) {
            request()->validate([
                'cv' => ['required', 'max:500000', 'mimes:docx,pdf'] // Max: 0.5GB (500MB)
            ]);
        } else {
            request()->validate([
                'cv_change' => ['max:500000', 'mimes:docx,pdf']
            ]);
        }

        // Update credentials in database
        $user = User::findOrFail($user_id);
        $personalDetailsId = $user->personalDetails->id;
        $userDetails = PersonalDetails::findOrFail($personalDetailsId);

        $userDetails->first_name = $request->first_name;
        $userDetails->last_name = $request->last_name;
        $userDetails->email = $request->email;
        $userDetails->skype_id = $request->skype_id;

        $userDetails->country_of_residence = $request->country_of_residence;
        $userDetails->mobile_number = $request->mobile_number;
        $userDetails->home_number = $request->home_number;

        $userDetails->highest_education = $request->highest_education;
        $userDetails->professional_experience = $request->professional_experience;
        $userDetails->industry_specialization = $request->industry_specialization;
        $userDetails->language_pairs = $request->language_pairs;

        $userDetails->tools = $request->tools;
        $userDetails->turnaround_per_day = $request->turnaround_per_day;
        $userDetails->currency_used = $request->currency_used;

        $userDetails->latest_remuneration = $request->latest_remuneration;
        $userDetails->expected_remuneration = $request->expected_remuneration;

        $userDetails->translation_rate = $request->translation_rate;
        $userDetails->editing_rate = $request->editing_rate;
        $userDetails->transcription_rate = $request->transcription_rate;
        $userDetails->hourly_rate = $request->hourly_rate;

        $userDetails->save();

        // Save CV to database and S3
        $cv = CV::firstOrCreate(['id' => $userDetails->cv->id]);
        $cv->personal_details_id = $userDetails->id;
        if($request->cv) {
            $cv->file_name = $request->cv->getClientOriginalName();
        } else if ($request->cv_change) {
            $cv->file_name = $request->cv_change->getClientOriginalName();
        }
        $cv->save();

        if($request->cv) {
            $cvFile = $request->cv;

            // Commit object to s3 with file path and contents of file (key:object)
            $filePathToStore = '/talentportal/' . $cv->id;
            \Storage::disk('s3')->put($filePathToStore, file_get_contents($cvFile));
            $user->hasCV = 1;
        }

        if($request->cv_change) {
            $cvFile = $request->cv_change;

            $filePathToStore = '/talentportal/' . $cv->id;
            \Storage::disk('s3')->put($filePathToStore, file_get_contents($cvFile));

            $user->hasCV = 1;
        }

        // Save profile picture to database S3
        $profilePicture = ProfilePicture::firstOrCreate(['id' => $userDetails->profilePicture->id]);
        $profilePicture->personal_details_id = $userDetails->id;
        if($request->profile_picture) {
            $profilePicture->file_name = $request->profile_picture->getClientOriginalName();
            $user->hasPFP = 1;
        }
        $profilePicture->save();

        // Save changes to user model (hasPFP, hasCV)
        $user->save();

        // Manipulate profile picture image before storing
        if ($request->profile_picture) {
            $pfpFile = $request->profile_picture;
            $manager = new Image(array('driver' => 'gd'));

            $fileSize = getimagesize($pfpFile);
            $shortestSide = $fileSize[0] > $fileSize[1] ? $fileSize[1] : $fileSize[0];

            $newPfp = $manager->make($pfpFile)
                ->crop($shortestSide, $shortestSide, 0, 0)
                ->resize(500, 500)
                ->save(storage_path() . '/app/public/user_data/profile_pictures/' . $profilePicture->id);
        }

        return redirect(route('personal_details'))->with([
            'success-message' => 'Personal details successfully updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PersonalDetails  $personalDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonalDetails $personalDetails)
    {
        //
    }
}
