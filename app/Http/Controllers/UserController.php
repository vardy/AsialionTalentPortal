<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

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

    public function add_role($user_id, $role_name, Request $request) {
        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        $user = User::findOrFail($user_id);

        if($user->hasRole($role_name)) {
            return Redirect::back()->withErrors([
                'That user already has that role.'
            ]);
        }

        if(Role::where('name', $role_name)->first()) {
            $user->roles()->attach(Role::where('name', $role_name)->first());
        } else {
            abort(404);
        }

        $user->save();

        return redirect()->back()->with([
            'success-message' => 'Successfully updated user\'s roles.'
        ]);
    }

    public function remove_role($user_id, $role_name, Request $request) {
        if(auth()->user()) {
            if(!auth()->user()->hasRole('admin')) {
                abort(403);
            }
        } else {
            return redirect('/login');
        }

        $user = User::findOrFail($user_id);

        if(!$user->hasRole($role_name)) {
            return Redirect::back()->withErrors([
                'That user does not have that role.'
            ]);
        }

        if(Role::where('name', $role_name)->first()) {
            $user->roles()->detach(Role::where('name', $role_name)->first());
        } else {
            abort(404);
        }

        $user->save();
        return redirect()->back()->with([
            'success-message' => 'Successfully updated user\'s roles.'
        ]);
    }

    public function update_password($user_id, Request $request) {
        request()->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = User::findOrFail($user_id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with([
            'success-message' => 'Successfully updated user\'s password.'
        ]);
    }
}
