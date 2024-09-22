<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Traits\ArticleFilterTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
    $articles = $query->paginate(10)->appends([
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
        return view('dashboard.article-create' , [

            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    public function edit(Request $request ){
        $request->validate([
            'id' =>'required|integer|exists:articles,id'
        ]);
        try {

            $article = Article::find($request->id);
            return view('dashboard.article-edit' , [
                'article' => $article,
                'categories' => Category::all(),
                'tags' => Tag::all()
            ]);
        } catch (\Throwable $th) {
            Log::debug( "ERROR EDIT ARTICLE METHOD  " . $th->getMessage());
            return response($th->getMessage() , 400);
        }

    }
    public function insert(Request $request){
        $request->validate([
              'name' => "string|min:10",
              'content' => "string|min:15",
              'category' => 'exists:categories,id|nullable',

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



        Session::flash('insert_article' , trans('Your Article saved'));
        return redirect()->back();
       } catch (\Throwable $th) {
            Log::debug("ERROR: create new article { ". $th->getMessage() ." }");
            return response($th->getMessage(),501);
       }
    }

    public function update(Request $request){



        $request->validate([

            'id' => 'integer|exists:articles,id',
            'name' => "string|min:10",
            'content' => "string|min:15",
            'category' => 'integer|exists:categories,id|nullable',
            'tags' => 'array|nullable',
            'tags.*' => 'integer|exists:tags,id',
        ]);
        try {
            $article = Article::find($request->id);
            $article->name = $request->name ;
            $article->content = $request->content ;
            $article->category_id = ($request->category > 0)  ? $request->category :null ;
            $article->save();
            $article->updateTags($request->tags);
            Session::flash('update_article' , trans('Your Article updated'));
            return redirect()->back();


        } catch (\Throwable $th) {
           return $th->getMessage();
        }

    }

    public function delete(Request $request , $id){
        try {
            if(!$id){
                throw new \Exception("ID article can't be null ");
            }else{
                // check if id is valid
                $article  = Article::find($id);
                if($article){
                    $name = $article->name;
                    $article->updateTags();
                    $article->delete();
                    Session::flash('delete-article' , trans("Article [:name] Deleted" , ['name' => $name]));
                    return redirect()->route('article.show');
                }else{
                    throw new \Exception("INVALID Article ID NUMBER , NOT FOUND");
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
