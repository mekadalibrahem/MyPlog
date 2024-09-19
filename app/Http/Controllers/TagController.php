<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function create(){
        $tags = Tag::all();
        return view('dashboard.tag' , ['tags' => $tags]);
    }
    public function insert(Request $request){
        $request->validate([
              'name' => "string|min:4|unique:tags,name"
        ]);

       try {
        Tag::create([
            'name' => $request->name
        ]);
        $request->session()->put('insert_tag' , trans('Your Tag saved'));
    return redirect()->back();
       } catch (\Throwable $th) {
            return $th->getMessage();
       }
    }

    public function update(Request $request){
        try {


            $request->validate([

                'old_name' => 'string|min:4|exists:tags,name',
                'new_name' => "string|min:4|unique:tags,name|different:old_name" ,
            ]);
            $tag = Tag::where('name' , $request->old_name)->first();
            $tag->name = $request->new_name ;
            $tag->save();
            $request->session()->put('update_tag' , trans('Your Tag updated'));
            return redirect()->back();


        } catch (\Throwable $th) {
           return $th->getMessage();
        }

    }

    public function delete(Request $request , $id){
        try {
            if($id == null){
                throw new \Exception("ID tag can't be null ");
            }else{
                // check if id is valid
                $tag  = Tag::find($id);
                if($tag){
                    $name = $tag->name;
                    $tag->delete();
                    $request->session()->put('delete-tag' , trans("Tag [:name] Deleted" , ['name' => $name]));
                    return redirect()->route('tag.create');
                }else{
                    throw new \Exception("INVALID TAG ID NUMBER , NOT FOUND");
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
