<?php

use Illuminate\Support\Facades\Route ;
use App\Http\Controllers\CategoryController;

Route::middleware([
    'auth.basic' , 'auth.session'
])->group(function(){
  Route::prefix('dashboard')->group(function(){
    Route::group(
        [
        'prefix' => 'category',
        'as' => 'category.'
        ],function(){
        Route::get('/' , [ CategoryController::class ,'create'])->name('create');
        Route::post('/create' , [CategoryController::class , 'insert'])->name('create');
        Route::post('/update' , [CategoryController::class , 'update'])->name('update');

    });
  });
});



