<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route ;




Route::middleware('guest')->group(function(){

    Route::view('/','home')->name('home');
    Route::view('/aboutme' , 'aboutme')->name('aboutme');
    Route::match(  ['get' , 'post'],  '/article' , [GuestController::class, 'all'])->name('articles');
    Route::get('/article/{id}' , [GuestController::class, 'index'])->name('article');


});




