<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function redirect_guest_users_to_login(): void
    {
        $this->get('/')->assertRedirect('/pretix/login');
    }

    /** @test */
    public function guest_users_see_login_page(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/pretix/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_login_with_pretix_secret(): void
    {
        $user = User::factory()->create(['token' => 'secrettoken']);

        $response = $this->get("/pretix/login/$user->token");
        $response->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_login_fail_with_wrong_pretix_secret(): void
    {
        User::factory()->create();

        $response = $this->get('/pretix/login/wrongtoken');
        $response->assertStatus(403);

        $this->assertGuest();
    }
}
