<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    private $user ;
    public function setUp(): void{
        parent::setUp();
        $this->user = User::factory()->create();
    }
    public function test_screen_show_render(){
        $response = $this->actingAs($this->user)->get('dashboard/article/show');
        $response->assertStatus(200);
    }
    public function test_screen_edit_render(){
        $article = Article::create([
            'name' => "test0000000000000000001",
            'content' => "test000000000000000000000001"
        ]);
        if($article->id >0){
            Log::debug($article->id);
            $uri = 'dashboard/article/update?id='. $article->id;
            $response = $this->actingAs($this->user)->get($uri  );

            $response->assertStatus(200);
            $responseArticle = $response->viewData('article');
            $this->assertEquals($article->id , $responseArticle->id);
            $this->assertEquals($article->name , $responseArticle->name);
            $this->assertEquals($article->content , $responseArticle->content);
        }

    }

    public function test_screen_create_render(){
        $response = $this->actingAs($this->user)->get('dashboard/article/create');
        $response->assertStatus(200);
    }

    public function test_create_without_tags_and_category(){
        $name = 'create test 01234567';
        $content = 'test content content test test 0928278287268882762' ;
        $response = $this->actingAs($this->user)->post('dashboard/article/insert',[
            'name' => $name,
            'content' => $content,
            'category' => null ,
            'tags' => []
        ]);


        $article = Article::where([
            'name' => $name ,
            'content' => $content
        ])->count();

        $this->assertEquals(1,$article);
    }

    public function test_create_with_category(){
        $name = 'create test 01234567';
        $content = 'test content content test test 0928278287268882762' ;
        $category = Category::create(['name' => 'IT']);
        $response = $this->actingAs($this->user)->post('dashboard/article/insert',[
            'name' => $name,
            'content' => $content,
            'category' => $category->id ,
            'tags' => []
        ]);


        $article = Article::where([
            'name' => $name ,
            'content' => $content,
            'category_id' => $category->id
        ])->count();

        $this->assertEquals(1,$article);
    }


    public function test_create_with_tags(){
        $name = 'create test 01234567';
        $content = 'test content content test test 0928278287268882762' ;
        $tag1 = Tag::create(['name' => 't1']);
        $tag2 = Tag::create(['name' => 't2']);
        $response = $this->actingAs($this->user)->post('dashboard/article/insert',[
            'name' => $name,
            'content' => $content,
            'category' => null,
            'tags' => [$tag1->id , $tag2->id]
        ]);


        $article = Article::where([
            'name' => $name ,
            'content' => $content,
            'category_id' => null,
        ])->first();

        $tags = ArticleTag::where('article_id' , $article->id)->count();

        $this->assertNotNull($article);
        $this->assertEquals(2,$tags);
    }
    public function test_create_with_tags_invalid(){
        $name = 'create test 01234567';
        $content = 'test content content test test 0928278287268882762' ;
        $tag1 = Tag::create(['name' => 't1']);

        $response = $this->actingAs($this->user)->post('dashboard/article/insert',[
            'name' => $name,
            'content' => $content,
            'category' => 1,
            'tags' => [$tag1->id , 2]
        ]);


        $article = Article::where([
            'name' => $name ,
            'content' => $content,
            'category_id' => null,
        ])->first();



        $this->assertNull($article);
        // $this->assertEquals(2,$tags);
    }
    public function test_create_with_category_invalid(){
        $name = 'create test 01234567';
        $content = 'test content content test test 0928278287268882762' ;

        $response = $this->actingAs($this->user)->post('dashboard/article/insert',[
            'name' => $name,
            'content' => $content,
            'category' => 1,
            'tags' => []
        ]);


        $article = Article::where([
            'name' => $name ,
            'content' => $content,
            'category_id' => null,
        ])->first();



        $this->assertNull($article);
        // $this->assertEquals(2,$tags);
    }

   public function test_screen_edit_article(){
        $article = Article::create([
            'name' => "test0000000000000000001",
            'content' => "test000000000000000000000001"
        ]);
        if($article->id >0){


            $response = $this->actingAs($this->user)->patch('dashboard/article/update' , [
                'id' => $article->id ,
                'name' => 'editTest0000000000000000000000',
                'content' => 'edit content 22222222222222222222222',
            ]);


           $edited = Article::find($article->id);
            $this->assertEquals($article->id , $edited->id);
            $this->assertEquals('editTest0000000000000000000000' , $edited->name);
            $this->assertEquals('edit content 22222222222222222222222' , $edited->content);
        }

    }

    public function test_screen_edit_article_category(){
        $article = Article::create([
            'name' => "test0000000000000000001",
            'content' => "test000000000000000000000001"
        ]);
        $category = Category::create(['name' => 'IT']);
        if($category){
            if($article->id >0){
                $response = $this->actingAs($this->user)->patch('dashboard/article/update' , [
                    'id' => $article->id ,
                    'name' => 'editTest0000000000000000000000',
                    'content' => 'edit content 22222222222222222222222',
                    'category' => $category->id
                ]);


                $edited = Article::find($article->id);
                $this->assertEquals($article->id , $edited->id);
                $this->assertEquals('editTest0000000000000000000000' , $edited->name);
                $this->assertEquals('edit content 22222222222222222222222' , $edited->content);
                $this->assertEquals($category->id , $edited->category_id);
            }
        }

    }

    public function test_screen_edit_article_invalid_category(){
        $article = Article::create([
            'name' => "test0000000000000000001",
            'content' => "test000000000000000000000001"
        ]);


            if($article->id >0){


                $response = $this->actingAs($this->user)->patch('dashboard/article/update' , [
                    'id' => $article->id ,
                    'name' => 'editTest0000000000000000000000',
                    'content' => 'edit content 22222222222222222222222',
                    'category' => 1
                ]);


                $edited = Article::find($article->id);
                $this->assertEquals($article->id , $edited->id);
                $this->assertNotEquals('editTest0000000000000000000000' , $edited->name);
                $this->assertNotEquals('edit content 22222222222222222222222' , $edited->content);
                $this->assertNotEquals(1 , $edited->category_id);
            }



    }


    public function test_screen_edit_article_category_tags(){

        $article = Article::create([
            'name' => "test0000000000000000001",
            'content' => "test000000000000000000000001"
        ]);
        $category = Category::create(['name' => 'IT']);
        $tag1 = Tag::create(['name' => 'tag1']);
        $tag2 = Tag::create(['name' => 'tag2']);
        if($category){
            if($article->id >0){
                $response = $this->actingAs($this->user)->patch('dashboard/article/update' , [
                    'id' => $article->id ,
                    'name' => 'editTest0000000000000000000000',
                    'content' => 'edit content 22222222222222222222222',
                    'category' => $category->id,
                    'tags' => [$tag1->id , $tag2->id]
                ]);


                $edited = Article::find($article->id);
                $this->assertEquals($article->id , $edited->id);
                $this->assertEquals('editTest0000000000000000000000' , $edited->name);
                $this->assertEquals('edit content 22222222222222222222222' , $edited->content);
                $this->assertEquals($category->id , $edited->category_id);
                $tags = ArticleTag::where('article_id' , $article->id)->get();
                $ids= [];
                foreach($tags as $tag){
                    $ids[] = $tag->tag_id;
                }
                $this->assertEquals($ids, [$tag1->id, $tag2->id]);

            }
        }

    }

    public function test_screen_edit_article_invalid_tags(){

      $article = Article::create([
          'name' => "test0000000000000000001",
          'content' => "test000000000000000000000001"
      ]);


          if($article->id >0){
              $response = $this->actingAs($this->user)->patch('dashboard/article/update' , [
                  'id' => $article->id ,
                  'name' => 'editTest0000000000000000000000',
                  'content' => 'edit content 22222222222222222222222',
                  'category' => null,
                  'tags' => [1,2]
              ]);


              $edited = Article::find($article->id);
              $this->assertEquals($article->id , $edited->id);
              $this->assertNotEquals('editTest0000000000000000000000' , $edited->name);
              $this->assertNotEquals('edit content 22222222222222222222222' , $edited->content);

              $tags = ArticleTag::where('article_id' , $article->id)->count();

              $this->assertEquals(0, $tags);


      }

  }


}
