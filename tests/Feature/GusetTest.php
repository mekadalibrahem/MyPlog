<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GusetTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void {
        parent::setUp();
        $this->artisan('db:seed'); // Assuming your seed populates articles, categories, and tags
    }
    public function test_render_home(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_render_aboutme(){
        $response = $this->get('/aboutme');
        $response->assertStatus(200);

    }
    public function test_render_articles(){
        $response = $this->get('/article');
        $response->assertStatus(200);
    }

    public function test_render_articles_with_category_filter(){
        $category = Category::first();
        $response = $this->post('/article' , [
            'filterCategory' => [$category->id]
        ]);
        $response->assertStatus(200);
        $articles = $response->viewData('articles')->count();
        $articles_c = Article::where('category_id' , $category->id)->paginate(10)->count();
        $this->assertEquals($articles_c , $articles);

    }
    public function test_render_articles_with_tag_filter(){
        $tag = Tag::first();
        $response = $this->post('/article' , [
            'filterTags' => [$tag->id]
        ]);
        $response->assertStatus(200);



    }
    public function test_render_article(){
        $article = Article::first();
        $uri = '/article/' . $article->id ;
        $response = $this->get($uri);
        $response->assertStatus(200);
        $respon_article = $response->viewData('article');
        $respon_releted = $response->viewData('releted');
        $releted = Article::where('category_id' , $article->category_id)->orderBy('created_at' , 'desc')->limit(5)->get();
        $releted2 = Article::query()->fcategory($article->category_id)
        ->orderBy('created_at' , 'desc')->limit(5)->get();
        $this->assertEquals($article->id , $respon_article->id);
        $this->assertEquals($respon_releted->count() , $releted->count());
        $this->assertEquals($respon_releted->count() , $releted2->count());

    }

}
