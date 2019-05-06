<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{


    public function invoice_delete() {
        $success_message = 'Invoice was successfully deleted.';

        if(auth()->user()->hasRole('admin')) {
            return redirect(route('admin'))->with([
                'success-message' => $success_message
            ]);
        } else {
            return redirect(route('invoices'))->with([
                'success-message' => $success_message
            ]);
        }
    }
}