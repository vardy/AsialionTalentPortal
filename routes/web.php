<?php


/* Generate authentication routes for pages such as 'login', 'register', and 'logout' */
Auth::routes();

Route::get('/', function () {
    return view('invoices');
});


// Invoice controllers
Route::get('/invoices', 'InvoiceController@create')->name('invoices');
Route::post('/invoices', 'InvoiceController@store');

// Other resource controllers
Route::get('/personal_details', 'PersonalDetailsController@index')->name('personal_details');

// Careers page redirects users to main AsiaLion site careers page
Route::get('/careers', function() {
    return view('careers');

})->name('careers');

// NDA PDF viewer page
Route::get('/nda', function () {
    return view('nda');
})->name('nda');