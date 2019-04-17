<?php


/* Generate authentication routes for pages such as 'login', 'register', and 'logout' */
Auth::routes();

Route::get('/', function () {
    return view('invoices');
});


// Resource controllers
Route::get('/invoices', 'InvoiceController@index')->name('invoices');
Route::get('/nda', 'NDAController@index')->name('nda');
Route::get('/personal_details', 'PersonalDetailsController@index')->name('personal_details');

// Careers page redirects users to main AsiaLion site careers page
Route::get('/careers', function() {
    return view('careers');

})->name('careers');


// Test route for CSS experimentation
Route::get('/test', function() {
   return view('test');
});