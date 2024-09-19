<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function create(){
        $categories = Category::all();
        return view('dashboard.category' , [
            'categories' => $categories
        ]);
    }

    public function insert(Request $request){
        $request->validate([
            'name' => "string|min:4|unique:categories,name"
        ]);

       try {
            Category::create([
                'name' => $request->name
            ]);
            $request->session()->put('insert_category' , trans('Your Category saved'));
        return redirect()->back();
       } catch (\Throwable $th) {
            return $th->getMessage();
       }
    }

    public function update(Request $request){
        try {



                $request->validate([

                    'old_name' => 'string|min:4|exists:categories,name',
                    'new_name' => "string|min:4|unique:categories,name|different:old_name" ,
                ]);
                $category = Category::where('name' , $request->old_name)->first();
                $category->name = $request->new_name ;
                $category->save();
                $request->session()->put('update_category' , trans('Your Category updated'));
                return redirect()->back();




        } catch (\Throwable $th) {
           return $th->getMessage();
        }

    }

    public function delete(Request $request , $id){
        try {
            if($id == null){
                throw new \Exception("ID category can't be null ");
            }else{
                // check if id is valid
                $category  = Category::find($id);
                if($category){
                    $name = $category->name;
                    $category->delete();
                    $request->session()->put('delete-category' , trans("Category [:name] Deleted" , ['name' => $name]));
                    return redirect()->back();
                }else{
                    throw new \Exception("INVALID CATEGORY ID NUMBER , NOT FOUND");
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
