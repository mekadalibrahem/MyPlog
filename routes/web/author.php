<?php

use App\Http\Controllers\ArticleController;
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
        Route::any('/create' , [ CategoryController::class ,'create'])->name('create');
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
    Route::group(
        [
        'prefix' => 'article',
        'as' => 'article.'
        ],function(){
        Route::match(['get', 'post'],'/show', [ArticleController::class , 'show'])->name('show');
        Route::get('/create' , [ ArticleController::class ,'create'])->name('create');
        Route::post('/create' , [ArticleController::class , 'insert'])->name('create');
        Route::get('/update' , [ArticleController::class , 'update'])->name('update');
        Route::patch('/update' , [ArticleController::class , 'update'])->name('update');
        Route::delete('/delete/{id}',[ArticleController::class , 'delete'])->name('delete');
        Route::get('/{id}/', [ArticleController::class , 'index'])->name('index');


    });
  });
});



