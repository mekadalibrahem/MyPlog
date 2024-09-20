<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all();
        $tagIds = Tag::pluck('id')->toArray();

        foreach ($articles as $article) {
            $randomTagIds = array_rand($tagIds, rand(1, 5)); // Randomly assign between 1 to 5 tags
            if (is_array($randomTagIds)) {
                foreach ($randomTagIds as $tagId) {
                    ArticleTag::create([
                        'tag_id' => $tagIds[$tagId],
                        'article_id' => $article->id,
                    ]);
                }
            } else {
                ArticleTag::create([
                    'tag_id' => $tagIds[$randomTagIds],
                    'article_id' => $article->id,
                ]);
            }
        }
    }
}
