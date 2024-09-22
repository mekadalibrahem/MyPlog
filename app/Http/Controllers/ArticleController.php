<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Traits\ArticleFilterTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{

    use ArticleFilterTrait;
    public function show(Request $request){
         // Start the query
    $query = Article::query();

    // Apply  filters if provided
    $fcategories = $request->input('filterCategory', []);
    $ftags = $request->input('filterTags', []);
    $this->ArticleFilter($query, $fcategories ?? null , $ftags ?? null );
    // Execute the query
    $articles = $query->paginate(5)->appends([
        'filterCategory' => $fcategories,
        'filterTags' => $ftags
    ]);
    // dd($articles);

    return view('dashboard.article', [
        'articles' => $articles,
        'categories' => Category::all(),
        'tags' => Tag::all(),
        'oldFCategories' => $fcategories,
        'oldFTags' => $ftags,
    ]);
    }
    public function create(){

    }

    public function edit(){

    }
    public function insert(Request $request){
        $request->validate([
              'name' => "string|min:10",
              'content' => "string|min:15",
              'category' => 'integer|exists:categories,id|nullable',

        ]);

       try {
       $article = new Article();
       $article->name = $request->name;
       $article->content= $request->content;
       $article->category_id = $request->category ?? null ;
       $article->save();
       if($request->tags !== []){

            $article->tags()->attach($request->tags);
            $article->save();
       }



        $request->session()->put('insert_article' , trans('Your Article saved'));
    return redirect()->back();
       } catch (\Throwable $th) {
            Log::debug("ERROR: create new article { ". $th->getMessage() ." }");
            return response($th->getMessage(),302);
       }
    }

    public function update(Request $request){
        try {


            $request->validate([

                'old_name' => 'string|min:4|exists:tags,name',
                'new_name' => "string|min:4|unique:tags,name|different:old_name" ,
            ]);
            $tag = Article::where('name' , $request->old_name)->first();
            $tag->name = $request->new_name ;
            $tag->save();
            $request->session()->put('update_article' , trans('Your Article updated'));
            return redirect()->back();


        } catch (\Throwable $th) {
           return $th->getMessage();
        }

    }

    public function delete(Request $request , $id){
        try {
            if($id == null){
                throw new \Exception("ID article can't be null ");
            }else{
                // check if id is valid
                $tag  = Article::find($id);
                if($tag){
                    $name = $tag->name;
                    $tag->delete();
                    $request->session()->put('delete-article' , trans("Article [:name] Deleted" , ['name' => $name]));
                    return redirect()->route('article.create');
                }else{
                    throw new \Exception("INVALID TAG ID NUMBER , NOT FOUND");
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
