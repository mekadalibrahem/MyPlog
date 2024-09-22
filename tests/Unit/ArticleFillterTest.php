<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ArticleFillterTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->artisan('db:seed'); // Assuming your seed populates articles, categories, and tags
    }

    public function test_get_without_filter(): void
    {
        $count = Article::count();  // Simpler way to count
        $this->assertEquals(50, $count);
    }

    public function test_filter_category(): void
    {
        $category = Category::find(1);
        $expected_count = Article::where('category_id', $category->id)->count();

        $article_query = Article::query();
        $actual_count = $article_query->fcategory([$category->id])->get()->count(); // Use `get` instead of `all`

        $this->assertEquals($expected_count, $actual_count);
    }

    public function test_filter_tag(): void
    {
        // Assuming tag 1 is attached to 15 articles
        $tag = Tag::find(1);
        $expected_count = ArticleTag::where('tag_id' , $tag->id)->get()->count();// Assuming many-to-many relation

        $article_query = Article::query();
        $actual_count = $article_query->ftags([$tag->id])->get()->count();

        $this->assertEquals($expected_count, $actual_count);
    }
    public function test_filter_mult_category(): void
    {
        // Testing for multiple categories
        $categories = Category::whereIn('id', [1, 2])->get();
        $expected_count = Article::whereIn('category_id', $categories->pluck('id'))->count();

        $article_query = Article::query();
        $actual_count = $article_query->fcategory([1,2])->get()->count();

        $this->assertEquals($expected_count, $actual_count);
    }

    public function test_filter_mult_tag(): void
    {
        // Testing for multiple tags
        $tags = Tag::whereIn('id', [1, 2])->get();

        // Calculate the expected count by ensuring articles are counted uniquely (distinct)
        $expected_count = Article::whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tag_id',[1,2]);
        })->distinct()->count();

        $article_query = Article::query();

        // Use distinct in the query to avoid double counting
        $actual_count = $article_query->ftags([1,2])->distinct()->get()->count();

        $this->assertEquals($expected_count, $actual_count);
    }

    public function test_filter_mult_tags_and_category(): void
    {
        // Testing for multiple tags and a category
        $categories = Category::whereIn('id', [1, 2])->get();
        $tags = Tag::whereIn('id', [1, 2])->get();

        $expected_count = Article::whereIn('category_id', [1,2])
            ->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tag_id', [1,2]);
            })->count();

        $article_query = Article::query();
        $actual_count = $article_query->fcategory([1,2])
            ->ftags([1,2])->get()->count();

        $this->assertEquals($expected_count, $actual_count);
    }
    public function test_show_render() : void {
        $response = $this->actingAs($this->user)->get('dashboard/article/show');
        $response->assertStatus(200);
        // Access the articles passed to the view
        $articles = $response->viewData('articles');

        // Assert the count of articles returned matches the expected count in the database
        $expected_count = Article::paginate(10)->count();
        $this->assertCount($expected_count, $articles);
    }
    public function test_show_render_with_single_category_filter() : void {
        // Simulate request with a single category filter
        $categoryId = 1;
        $response = $this->actingAs($this->user)->post('dashboard/article/show' ,[
            'category' => $categoryId
        ]);

        // Assert the status is 200
        $response->assertStatus(200);

        // Access the articles passed to the view
        $articles = $response->viewData('articles');

        // Calculate the expected count based on the category filter
        $expected_count = Article::where('category_id', $categoryId)->paginate(10)->count();

        // Assert the count of filtered articles
        $this->assertCount($expected_count, $articles);
    }
    public function test_show_render_with_multiple_category_filters() : void {
        // Simulate request with multiple category filters (e.g., category IDs 1 and 2)
        $categoryIds = [1, 2];
        $response = $this->actingAs($this->user)->post('dashboard/article/show' ,[
            'category' => $categoryIds
        ] );

        // Assert the status is 200
        $response->assertStatus(200);

        // Access the articles passed to the view
        $articles = $response->viewData('articles');

        // Calculate the expected count based on multiple categories
        $expected_count = Article::whereIn('category_id', $categoryIds)->paginate(10)->count();

        // Assert the count of filtered articles
        $this->assertCount($expected_count, $articles);
    }
    public function test_show_render_with_single_tag_filter() : void {
        // Simulate request with a single tag filter
        $tagId = 1;
        $response = $this->actingAs($this->user)->post('dashboard/article/show',['tag' => $tagId]);

        // Assert the status is 200
        $response->assertStatus(200);

        // Access the articles passed to the view
        $articles = $response->viewData('articles');

        // Calculate the expected count based on the tag filter
        $expected_count = Article::whereHas('tags', function ($query) use ($tagId) {
            $query->where('tag_id', $tagId);
        })->paginate(10)->count();

        // Assert the count of filtered articles
        $this->assertCount($expected_count, $articles);
    }
    public function test_show_render_with_multiple_tag_filters() : void {
        // Simulate request with multiple tag filters (e.g., tag IDs 1 and 2)
        $tagIds = [1, 2];
        $response = $this->actingAs($this->user)->post('dashboard/article/show',['tag' => $tagIds]);

        // Assert the status is 200
        $response->assertStatus(200);

        // Access the articles passed to the view
        $articles = $response->viewData('articles');

        // Calculate the expected count based on multiple tags
        $expected_count = Article::whereHas('tags', function ($query) use ($tagIds) {
            $query->whereIn('tag_id', $tagIds);
        })->distinct()->paginate(10)->count(); // Ensure articles are counted once if they have multiple tags

        // Assert the count of filtered articles
        $this->assertCount($expected_count, $articles);
    }
    public function test_show_render_with_tag_and_category_filters() : void {
        // Simulate request with both category and tag filters
        $categoryIds = [1, 2];
        $tagIds = [1, 2];
        $response = $this->actingAs($this->user)->post('dashboard/article/show' , [
            'category' => $categoryIds,
            'tag' => $tagIds
        ]);
        // Assert the status is 200
        $response->assertStatus(200);

        // Access the articles passed to the view
        $articles = $response->viewData('articles');

        // Calculate the expected count based on both categories and tags
        $expected_count = Article::whereIn('category_id', $categoryIds)
            ->whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tag_id', $tagIds);
            })
            ->distinct()
            ->paginate(10)->count();

        // Assert the count of filtered articles
        $this->assertCount($expected_count, $articles);
    }



}
