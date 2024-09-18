<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function create(){
        return view('dashboard.category');
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

    }
}
