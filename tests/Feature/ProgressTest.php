<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LinuxCourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgressTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_fetch_learning_progress(): void
    {
        $this->seed(LinuxCourseSeeder::class);
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson('/api/v1/progress');

        $response->assertOk()
            ->assertJsonStructure([
                'courses' => [
                    '*' => [
                        'course_id',
                        'course_title',
                        'completed_lessons',
                        'total_lessons',
                        'progress_percent',
                    ]
                ]
            ]);
    }
}
