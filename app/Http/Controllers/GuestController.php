<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Traits\ArticleFilterTrait;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    use ArticleFilterTrait;
    public function all(Request $request ){
        try {
            // Start the query
    $query = Article::query();

    // Apply  filters if provided
    $fcategories = $request->input('filterCategory', []);
    $ftags = $request->input('filterTags', []);
    $this->ArticleFilter($query, $fcategories ?? null , $ftags ?? null );
    // Execute the query
    $articles = $query->paginate(10)->appends([
        'filterCategory' => $fcategories,
        'filterTags' => $ftags
    ]);
    // dd($articles);

    return view('articles', [
        'articles' => $articles,
        'categories' => Category::all(),
        'tags' => Tag::all(),
        'oldFCategories' => $fcategories,
        'oldFTags' => $ftags,
    ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function index(Request $request , $id){
        try{
             if(!$id){
                 return route('articles');
             }else{
                 $article  = Article::find($id);
                 $releted = Article::query()->fcategory($article->category_id)->orderBy('created_at','desc')->limit(5)->get();
                 if($article){
                     return view('article' , [
                         'article' => $article ,
                         'releted'=> $releted
                     ]);
                 }else{
                     return route('articles');
                 }
             }
        }catch(\Throwable $th){
         return $th->getMessage();
     }
     }
}
