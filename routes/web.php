<?php


/* Generate authentication routes for pages such as 'login', 'register', and 'logout' */
Auth::routes();

Route::get('/', function () {
    return redirect(route('invoices'));
});

// User controller
Route::delete('/user/{user_id}', 'UserController@destroy');

// Invoice controllers
Route::get('/invoices', 'InvoiceController@index')->name('invoices');
Route::get('/invoices/{invoice}', 'InvoiceController@show');
Route::post('/invoices', 'InvoiceController@store');
Route::delete('/invoices/{invoice}', 'InvoiceController@destroy');

// File controller
Route::get('/files/{file}', 'FileController@show');

// CV controller
Route::get('/cvs/{cv}', 'CVController@show');

// Personal details controller
Route::get('/personal_details', 'PersonalDetailsController@index')->name('personal_details');
Route::put('/personal_details/{user_id}', 'PersonalDetailsController@update');

// Profile picture controller
Route::delete('/profile_pictures/{pfp_id}', 'ProfilePictureController@destroy')->name('profile_pictures');

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

// Admin panel
// List users - ADMIN ONLY
Route::get('/admin', 'AdminController@index')->name('admin'); // All users, add user, delete user, change NDA file, all invoices
Route::get('/admin/register', 'AdminController@show_registration_form');
Route::post('/admin/register', 'AdminController@create_user');
Route::get('/admin/user/{user_id}', 'AdminController@show_user'); // User invoices, user personal details, lock details, remove PFP
Route::get('/admin/invoice/{invoice_id}', 'AdminController@show_invoice'); // Show individual invoice
Route::put('/admin/update_nda', 'AdminController@update_nda')->name('update_nda'); // Change file in /storage/files/NDA.pdf
// S3 file controls
// Display files and links for purging - ADMIN ONLY
Route::get('/admin/s3', 'AdminController@s3_index')->name('s3');
Route::delete('/admin/s3/smart_purge', 'AdminController@smart_purge');
Route::delete('/admin/s3/purge');

// Misc intermediate controllers
Route::get('/redirect/invoice_delete', 'RedirectController@invoice_delete');