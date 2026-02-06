<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $token;
    private $user;

    public function test_1_user_can_register(): void
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

    public function test_2_user_can_login(): void
    {
        // Crear usuario
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function test_3_user_can_create_project(): void
    {
        // Crear y autenticar usuario
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->token = $loginResponse->json('token');

        // Crear proyecto
        $response = $this->postJson('/api/projects', [
            'name' => 'Proyecto Test',
            'description' => 'Descripción del proyecto',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('projects', [
            'name' => 'Proyecto Test',
        ]);
    }

    public function test_4_user_can_view_projects(): void
    {
        // Crear y autenticar usuario
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->token = $loginResponse->json('token');

        // Crear proyecto
        Project::create([
            'user_id' => $this->user->id,
            'name' => 'Proyecto Test',
            'description' => 'Descripción',
        ]);

        // Ver proyectos
        $response = $this->getJson('/api/projects', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);
    }

    public function test_5_user_can_create_task(): void
    {
        // Crear y autenticar usuario
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->token = $loginResponse->json('token');

        // Crear proyecto
        $project = Project::create([
            'user_id' => $this->user->id,
            'name' => 'Proyecto Test',
            'description' => 'Descripción',
        ]);

        // Crear tarea
        $response = $this->postJson('/api/tasks', [
            'project_id' => $project->id,
            'title' => 'Nueva Tarea',
            'description' => 'Descripción de la tarea',
            'status' => 'pending',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Nueva Tarea',
            'project_id' => $project->id,
        ]);
    }
}