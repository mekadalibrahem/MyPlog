<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categoryIds = Category::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            Article::create([
                'name' => $faker->sentence,
                'content' => $faker->paragraph,
                'category_id' => $faker->randomElement($categoryIds),
            ]);
        }
    }
}
