<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery\Expectation;
use Tests\TestCase;
use Throwable;

class CategoryTest extends TestCase
{

    use RefreshDatabase ;
    public $user ;
    /**
     * A basic feature test example.
     */
    public function test_category_screen_can_render(): void
    {

        $user = $this->auth();
        // Act as the authenticated user
        $response = $this->actingAs($user)->get('dashboard/category/create');
        // Assert that the page loads successfully
        $response->assertStatus(200);
    }

    public function test_can_create_category(){
        $name = 'test01';
        $user = $this->auth();
        $this->actingAs($user)->post('dashboard/category/create', [
            'name' => $name
        ]);

        $count = Category::where('name' , $name)->count();
        $this->assertEquals(1,$count);
    }

    public function test_can_update_category(){
        $old_name = 'test01';
        $new_name = 'test_updated';
        $user = $this->auth();
        Category::create(['name'=>$old_name]);
        $category = Category::where('name', $old_name)->first();
        if($category){
            $befor_updated = Category::where('name', $new_name)->count();
            $this->assertEquals(0,$befor_updated);
            $this->actingAs($user)->post('dashboard/category/update', [
                'old_name' => $old_name,
                'new_name' => $new_name
            ]);

            $new_category = Category::where('name', $new_name)->count();
            $this->assertEquals(1,$new_category);

        }else{
            $this->fail('Category Not Found');
        }


    }

    public function test_can_delete_category(){
        $name = 'test_updated';
        // $this->withoutMiddleware();
        $user  = User::factory()->create();


        Category::create(['name'=>$name]);
        $category = Category::where('name', $name)->first();
        if($category){
            $uri = "dashboard/category/delete/$category->id";

            $respone = $this->actingAs($user)->delete($uri);



           
            $count = Category::where('name', $name)->count();
            $this->assertEquals(0, $count);
        } else {
            $this->fail('Category Not Found');
        }
    }

    protected function auth(){
        // Create a user and authenticate them

            $this->user = User::factory()->create();

            return $this->user ;

    }
}
