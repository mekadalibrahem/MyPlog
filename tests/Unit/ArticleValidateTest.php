<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleValidateTest extends TestCase
{
    use RefreshDatabase ;
    private $user ;

    public function setUp(): void{
        parent::setUp();
        $this->user = User::factory()->create();
    }
    public function test_create_article_without_any_tag_category(): void
    {
        $data = [
            'name' => 'test1234567890' ,
            "content" => "content 12345678901234567890",
            'category' => null ,
            'tags' => [] ,
        ];
        $response  = $this->actingAs($this->user)->post('dashboard/article/insert' , $data);
        // $response->assertStatus(200);
        $article = Article::where('name' , 'test1234567890')->first();

        if($article){
            $this->assertEquals('test1234567890', $article->name);
        }else{
            $this->fail($article);
        }
    }

    public function test_create_invalid_name():void{
        $data = [
            'name' => 'test' ,
            "content" => "content 12345678901234567890",
            'category' => null ,
            'tags' => null ,
        ];
        $response  = $this->actingAs($this->user)->post('dashboard/article/insert' , $data);
        $response->assertStatus(302);
    }
    public function test_create_invalid_content():void{
        $data = [
            'name' => 'test1234567890' ,
            "content" => "content ",
            'category' => null ,
            'tags' => null ,
        ];
        $response  = $this->actingAs($this->user)->post('dashboard/article/insert' , $data);
        $response->assertStatus(302);
    }

    public function test_create_invalid_category():void{
        $data = [
            'name' => 'test1234567890' ,
            "content" => "content 12345678901234567890",
            'category' => "IT" ,
            'tags' => null ,
        ];
        $response  = $this->actingAs($this->user)->post('dashboard/article/insert' , $data);
        $response->assertStatus(302);
    }

    public function test_create_invalid_tag():void{
        $data = [
            'name' => 'test1234567890' ,
            "content" => "content 12345678901234567890",
            'category' => null ,
            'tags' => [1,2,3] ,
        ];
        $response  = $this->actingAs($this->user)->post('dashboard/article/insert' , $data);
        $response->assertStatus(501);
    }

    public function test_create_with_category(){
        Category::create(['name' => 'IT']);
        $cat = Category::where('name', 'IT')->first();
        $data = [
            'name' => 'test1234567890' ,
            "content" => "content 12345678901234567890",
            'category' =>  $cat->id,
            'tags' => null ,
        ];

        $response  = $this->actingAs($this->user)->post('dashboard/article/insert' , $data);
        // $response->assertStatus(200);
        $article = Article::where('name' , 'test1234567890')->first();
        $this->assertEquals('test1234567890', $article->name);
        $this->assertEquals($cat->id, $article->category_id);
    }

    public function test_create_with_tags(){
        Tag::create(['name' => 'IT']);
        Tag::create(['name' => 'BOOK']);
        $tag_it = Tag::where('name', 'IT')->first();
        $tag_book = Tag::where('name', 'BOOK')->first();
        $tags_list =[$tag_it->id, $tag_book->id];
        $data = [
            'name' => 'test1234567890' ,
            "content" => "content 12345678901234567890",
            'category' =>  null,
            'tags' => $tags_list ,
        ];

        $response  = $this->actingAs($this->user)->post('dashboard/article/insert' , $data);
        $response->assertStatus(302);
        $article = Article::where('name' , 'test1234567890')->first();
        $this->assertEquals('test1234567890', $article->name);
        $tags = $article->tags ;
        $ids = [];
        foreach($tags as $t){
            $ids[]= $t->id;
        }
        $this->assertEquals($tags_list, $ids);

    }

}
