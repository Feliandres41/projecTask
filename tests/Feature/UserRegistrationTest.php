<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    // Resetea la base de datos después de cada prueba
    // use RefreshDatabase;

    /**
     * Traducción del Caso de Prueba CP-REG-001.
     */
   public function test_new_users_can_register(): void
{
    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
}


}
