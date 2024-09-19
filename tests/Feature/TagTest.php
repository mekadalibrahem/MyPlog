<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase ;
    public function test_tag_screen_can_render(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('dashboard/tag/create');

        $response->assertStatus(200);
    }
    public function test_can_create_tag(){
        $name = 'test01';
        $user =  $user = User::factory()->create();
        $this->actingAs($user)->post('dashboard/tag/create', [
            'name' => $name
        ]);

        $count = Tag::where('name' , $name)->count();
        $this->assertEquals(1,$count);
    }

    public function test_can_update_tag(){
        $old_name = 'test01';
        $new_name = 'test_updated';
        $user =  $user = User::factory()->create();
        Tag::create(['name'=>$old_name]);
        $tag = Tag::where('name', $old_name)->first();
        if($tag){
            $befor_updated = Tag::where('name', $new_name)->count();
            $this->assertEquals(0,$befor_updated);
            $this->actingAs($user)->post('dashboard/tag/update', [
                'old_name' => $old_name,
                'new_name' => $new_name
            ]);

            $new_tag = Tag::where('name', $new_name)->count();
            $this->assertEquals(1,$new_tag);

        }else{
            $this->fail('Tag Not Found');
        }


    }

    public function test_can_delete_tag(){
        $name = 'test_updated';
        // $this->withoutMiddleware();
        $user  = User::factory()->create();


        Tag::create(['name'=>$name]);
        $tag = Tag::where('name', $name)->first();
        if($tag){
            $uri = "dashboard/tag/delete/$tag->id";

            $respone = $this->actingAs($user)->delete($uri);




            $count = Tag::where('name', $name)->count();
            $this->assertEquals(0, $count);
        } else {
            $this->fail('Tag Not Found');
        }
    }

}
