<?php

namespace App\Http\Controllers;

use App\CV;
use App\Invoice;
use App\PersonalDetails;
use App\ProfilePicture;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        return view('admin.index', [
            'users' => User::all(),
            'invoices' => Invoice::all()
        ]);
    }

    public function s3_index() {

        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        return view('admin.s3.index', [
            's3_files' => Storage::disk('s3')->files('talentportal')
        ]);
    }

    public function update_nda(Request $request) {

        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        $request->validate([
            'nda' => 'mimes:pdf'
        ]);

        $path = $request->nda->storeAs('public/files/', 'NDA.pdf');

        return redirect(route('admin'))->with([
            'success-message' => 'NDA updated successfully.'
        ]);
    }

    public function show_invoice($invoice_id, Request $request) {

        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        $invoice = Invoice::findOrFail($invoice_id);

        return view('admin.invoice', [
            'invoice' => $invoice
        ]);
    }

    public function show_user($user_id, Request $request) {

        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        $user = User::findOrFail($user_id);
        $roles = $user->roles;

        return view('admin.user', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function show_registration_form() {

        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        return view('admin.register');
    }

    public function create_user(Request $request) {

        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        $personal_details = new PersonalDetails();
        $personal_details->user_id = $user->id;
        $personal_details->save();

        $cv = new CV();
        $cv->personal_details_id = $personal_details->id;
        $cv->save();

        $profile_picture = new ProfilePicture();
        $profile_picture->personal_details_id = $personal_details->id;
        $profile_picture->save();

        return redirect(route('admin'));
    }
}
