<?php

use App\Models\Article;
use Illuminate\Support\Facades\Route;

Route::prefix('test')->group(function(){

    Route::get('/articleFilter' , function(){
        $articles = [];
        $tagIds = [1,2];
        $articles =         Article::whereIn('category_id', [1,2])
                        ->whereHas('tags', function ($query) use ($tagIds) {
                            $query->whereIn('tag_id', $tagIds);
                        })
                        ->distinct()
                        ->count();

        return $articles;
    });

});


