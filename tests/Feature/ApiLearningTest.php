<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LinuxCourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiLearningTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_courses(): void
    {
        $this->seed(LinuxCourseSeeder::class);
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $this->withToken($token)
            ->getJson('/api/v1/courses')
            ->assertOk()
            ->assertJsonCount(4);
    }
}
