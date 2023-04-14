<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PeopleController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::view('/', 'teste');
    Route::resource('/people', PeopleController::class);
    Route::any('/people/search', [PeopleController::class, 'search'])->name('people.search');

    Route::delete('/contact/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
