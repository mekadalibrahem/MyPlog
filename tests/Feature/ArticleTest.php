<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

}
