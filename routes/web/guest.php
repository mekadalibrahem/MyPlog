<?php

use Illuminate\Support\Facades\Route ;




Route::middleware('guest')->group(function(){

    Route::view('/','home')->name('home');
    Route::view('/aboutme' , 'aboutme')->name('aboutme');
    Route::view('/article' , "article")->name('article');


});




