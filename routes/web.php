<?php


/* Generate authentication routes for pages such as 'login', 'register', and 'logout' */
Auth::routes();

Route::get('/', function () {
    return redirect(route('invoices'));
});


// Invoice controllers
Route::get('/invoices', 'InvoiceController@index')->name('invoices');
Route::get('/invoices/{invoice}', 'InvoiceController@show');
Route::post('/invoices', 'InvoiceController@store');
Route::delete('/invoices/{invoice}', 'InvoiceController@destroy');

// File controller
Route::get('/files/{file}', 'FileController@show');

// Other resource controllers
Route::get('/personal_details', 'PersonalDetailsController@index')->name('personal_details');

// Careers page redirects users to main AsiaLion site careers page
Route::get('/careers', function() {
    $careers_url = 'https://www.asialion.com/careers/';
    return Redirect::to($careers_url);
})->name('careers');

// NDA PDF viewer page
Route::get('/nda', function () {
    if (auth()->user()) {
        return view('nda');
    } else {
        return redirect(route('login'));
    }
})->name('nda');

// Admin temporary panel
Route::get('/admin', 'AdminController@index')->name('admin');