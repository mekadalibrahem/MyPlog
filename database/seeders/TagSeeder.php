<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create(['name' => 'web']);
        Tag::create(['name' => 'algorthim']);
        Tag::create(['name' => 'C#']);
        Tag::create(['name' => 'php']);
        Tag::create(['name' => 'laravel']);
        Tag::create(['name' => 'python']);
        Tag::create(['name' => 'softwere']);
        Tag::create(['name' => 'desaign']);
        Tag::create(['name' => 'desaign pattern']);
        Tag::create(['name' => 'freamwork']);
        Tag::create(['name' => 'packages']);
        Tag::create(['name' => 'android']);
    }
}
