<?php

use Illuminate\Support\Facades\Route ;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;

Route::middleware([
    'auth' , 'auth.session'
])->group(function(){
  Route::prefix('dashboard')->group(function(){
    Route::group(
        [
        'prefix' => 'category',
        'as' => 'category.'
        ],function(){
        Route::get('/create' , [ CategoryController::class ,'create'])->name('create');
        Route::post('/create' , [CategoryController::class , 'insert'])->name('create');
        Route::post('/update' , [CategoryController::class , 'update'])->name('update');
        Route::delete('/delete/{id}',[CategoryController::class , 'delete'])->name('delete');

    });
    Route::group(
        [
        'prefix' => 'tag',
        'as' => 'tag.'
        ],function(){
        Route::get('/create' , [ TagController::class ,'create'])->name('create');
        Route::post('/create' , [TagController::class , 'insert'])->name('create');
        Route::post('/update' , [TagController::class , 'update'])->name('update');
        Route::delete('/delete/{id}',[TagController::class , 'delete'])->name('delete');

    });
  });
});



