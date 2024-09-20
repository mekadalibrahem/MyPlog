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
        $actual_count = $article_query->category([$category->id])->get()->count(); // Use `get` instead of `all`

        $this->assertEquals($expected_count, $actual_count);
    }

    public function test_filter_tag(): void
    {
        // Assuming tag 1 is attached to 15 articles
        $tag = Tag::find(1);
        $expected_count = ArticleTag::where('tag_id' , $tag->id)->get()->count();// Assuming many-to-many relation

        $article_query = Article::query();
        $actual_count = $article_query->articletag([$tag->id])->get()->count();
        // Log::debug($article_query->tag([$tag->id])->get());                                                                                                                       );
        $this->assertEquals($expected_count, $actual_count);
    }
    public function test_filter_mult_category(): void
    {
        // Testing for multiple categories
        $categories = Category::whereIn('id', [1, 2])->get();
        $expected_count = Article::whereIn('category_id', $categories->pluck('id'))->count();

        $article_query = Article::query();
        $actual_count = $article_query->category($categories->pluck('id'))->get()->count();

        $this->assertEquals($expected_count, $actual_count);
    }

    public function test_filter_mult_tag(): void
    {
        // Testing for multiple tags
        $tags = Tag::whereIn('id', [1, 2])->get();

        // Calculate the expected count by ensuring articles are counted uniquely (distinct)
        $expected_count = Article::whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tag_id', $tags->pluck('id'));
        })->distinct()->count();

        $article_query = Article::query();

        // Use distinct in the query to avoid double counting
        $actual_count = $article_query->articletag($tags->pluck('id'))->distinct()->get()->count();

        $this->assertEquals($expected_count, $actual_count);
    }

    public function test_filter_mult_tags_and_category(): void
    {
        // Testing for multiple tags and a category
        $categories = Category::whereIn('id', [1, 2])->get();
        $tags = Tag::whereIn('id', [1, 2])->get();

        $expected_count = Article::whereIn('category_id', $categories->pluck('id'))
            ->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tag_id', $tags->pluck('id'));
            })->count();

        $article_query = Article::query();
        $actual_count = $article_query->category($categories->pluck('id'))
            ->articletag($tags->pluck('id'))->get()->count();

        $this->assertEquals($expected_count, $actual_count);
    }
}
