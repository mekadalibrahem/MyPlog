<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;


class ArticleModelTest extends TestCase
{
    use RefreshDatabase;
    private $category_it ;
    private $category_web ;
    private $category_book ;
    private $tag_php ;
    private $tag_android ;
    private $tag_python ;
    private $article;
    public function setUp(): void{

        parent::setUp();
        $this->category_it = Category::create(['name' => 'IT']);
        $this->category_web = Category::create(['name' => 'WEB']);
        $this->category_book = Category::create(['name' => 'BOOK']);
        $this->tag_php = Tag::create(['name' => 'PHP']);
        $this->tag_android = Tag::create(['name' => 'ANDROID']);
        $this->tag_python = Tag::create(['name' => 'PYTHON']);
        $this->article = Article::create([
            'name' => 'test01',
            'content' => 'content test',
        ]);



    }

    public function test_article_table_schema(){
        $this->assertTrue(Schema::hasColumns('articles',[
            'id' ,'name' ,'content' , 'category_id' ,'created_at' , 'updated_at'
        ]));
    }

    public function test_create_article(): void
    {

       try {

        $article  = new Article();
        $article->name = "test";
        $article->content =  "test content .............. ... ..... .... .... .... test";
        $article->save();


        $art = Article::where('name', 'test')->first();
        $this->assertEquals($article->id,$art->id);
       } catch (\Throwable $th) {
            $this->fail($th->getMessage());
       }
    }

    public function test_updated_article(){
        $article  = new Article();
        $article->name = "test";
        $article->content =  "test content .............. ... ..... .... .... .... test";
        $article->save();
        $new_content = "new_name";
        $article->content = $new_content;
        $article->save();
        $art = Article::where('name', "test")->first();
        $this->assertEquals($new_content,$art->content);
    }

    public function test_delete_article(){
        $article  = new Article();
        $article->name = "test";
        $article->content =  "test content .............. ... ..... .... .... .... test";
        $article->save();

        $article->delete();
        $art = Article::where('name', "test")->count();
        $this->assertEquals(0,$art);
    }


    public function test_article_no_has_tags(){

        $tags = $this->article->tags;
        $this->assertCount(0 ,$tags);
        // $this->assertNull();
    }
    public function test_article_no_has_category(){

        $category = $this->article->category;
        // $this->fail($category);
        $this->assertnull($category);
        // $this->assertNull();
    }

    public function test_article_set_catgory(){

        $art = $this->article ;
        $art->category_id = $this->category_it->id ;
        $art->save();
        $this->assertEquals($this->category_it->name , $art->category->name);

    }


    public function test_get_article_by_catgeory(){
        $category = $this->category_book ;
        $article = $this->article ;

        $article->category_id = $category->id;
        $article->save();
        $article_c = $category->articles->where('name' , $article->name)->first() ;
        $this->assertEquals($article->name , $article_c->name);

    }

    public function test_set_tag_to_article(){
        $article = $this->article ;
        $tag = $this->tag_php ;
        $article->tags()->attach($tag->id);
        $article->save();
        $tag_c = $article->tags->where('name' , $tag->name)->first();
        $this->assertEquals($tag->name ,$tag_c->name);
    }

    public function test_set_tags_to_articles(){
        $article = $this->article ;
        $tags_id = [
            $this->tag_php->id ,
            $this->tag_python->id,
        ];
        $article->tags()->attach($tags_id);
        // $article->tags()->attach($tags_id[1]);
        $article->save();
        $tag_c = $article->tags;
        $actual_tags = [];
        foreach($tag_c as $t){
            $actual_tags[] = $t->id;
        }
        $this->assertEquals($tags_id, $actual_tags);
    }

    public function test_get_article_by_tag(){
        $article = $this->article;
        $tag = $this->tag_android;
        $article->tags()->attach($tag->id);
        $article->save();
        $a = $tag->articles->where('name' , $article->name)->first();
        $this->assertEquals($article->id , $a->id);
    }

}
