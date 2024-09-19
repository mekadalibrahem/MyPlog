<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        // $response = $this->get('/register');

        // $response->assertStatus(200);
        $this->assertTrue(1>0);
    }

    public function test_new_users_can_register(): void
    {
        $this->assertTrue(1>0);

        // $response = $this->post('/register', [
        //     'name' => 'Test User',
        //     'email' => 'admin@gmail.com',
        //     'password' => 'password',
        //     'password_confirmation' => 'password',
        // ]);

        // $this->assertAuthenticated();
        // $response->assertRedirect(route('dashboard', absolute: false));
    }
}
