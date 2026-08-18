<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonAttemptTest extends TestCase
{
    use RefreshDatabase;

    private function createExercise(string $expectedAnswer, bool $caseSensitive = false): Exercise
    {
        $course = Course::create([
            'slug' => 'test-course',
            'title' => 'Test Course',
            'description' => 'Description',
            'level' => 'principiante',
            'order' => 1,
        ]);

        $module = Module::create([
            'course_id' => $course->id,
            'title' => 'Test Module',
            'order' => 1,
        ]);

        $lesson = Lesson::create([
            'module_id' => $module->id,
            'slug' => 'test-lesson',
            'title' => 'Test Lesson',
            'content' => 'Content',
            'order' => 1,
        ]);

        return Exercise::create([
            'lesson_id' => $lesson->id,
            'type' => 'command',
            'prompt' => 'Ejecuta el comando para listar archivos',
            'expected_answer' => $expectedAnswer,
            'hint' => 'Usa ls',
            'case_sensitive' => $caseSensitive,
            'explanation' => 'ls lista archivos',
        ]);
    }

    public function test_correct_command_attempt_completes_lesson(): void
    {
        $exercise = $this->createExercise('ls -l');
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson("/api/v1/exercises/{$exercise->id}/attempt", [
                'answer' => 'ls -l',
            ]);

        $response->assertOk()
            ->assertJson([
                'correct' => true,
                'lesson_completed' => true,
            ]);

        $this->assertDatabaseHas('exercise_attempts', [
            'user_id' => $user->id,
            'exercise_id' => $exercise->id,
            'correct' => 1,
        ]);

        $this->assertDatabaseHas('user_lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $exercise->lesson_id,
        ]);
    }

    public function test_incorrect_command_attempt_returns_hint(): void
    {
        $exercise = $this->createExercise('ls -l');
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson("/api/v1/exercises/{$exercise->id}/attempt", [
                'answer' => 'pwd',
            ]);

        $response->assertOk()
            ->assertJson([
                'correct' => false,
                'explanation' => 'Usa ls',
            ]);

        $this->assertDatabaseHas('exercise_attempts', [
            'user_id' => $user->id,
            'exercise_id' => $exercise->id,
            'correct' => 0,
        ]);
    }
}
