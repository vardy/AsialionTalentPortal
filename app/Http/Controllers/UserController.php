<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy($user_id) {
        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect(route('admin'))->with([
            'success-message' => 'User successfully deleted.'
        ]);
    }
}
