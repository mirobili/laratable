<?php

use Illuminate\Support\Facades\Route;

// Handle all GET requests by returning the welcome view
// This allows React Router to handle the frontend routing
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');




// Handle all GET requests by returning the welcome view
// This allows React Router to handle the frontend routing
Route::get('/new_order', function (Request $request) {

    return 1111111111111111;
    return $request->asd;
}) ;



