<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller {

    public function index() {
        if(auth()->user()) {
            auth()->user()->authorizeRoles(['admin']);
        } else {
            return redirect('/login');
        }

        dd(Storage::disk('s3')->allFiles());
    }
}