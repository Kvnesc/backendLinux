<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\ExerciseAttempt;
use App\Models\Lesson;
use App\Models\UserLessonProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function show(Request $request, Lesson $lesson): JsonResponse
    {
        $lesson->load('exercises');
        $completed = UserLessonProgress::where('user_id', $request->user()->id)
            ->where('lesson_id', $lesson->id)
            ->whereNotNull('completed_at')
            ->exists();

        return response()->json([
            'id' => $lesson->id,
            'title' => $lesson->title,
            'content' => $lesson->content,
            'command_example' => $lesson->command_example,
            'estimated_minutes' => $lesson->estimated_minutes,
            'completed' => $completed,
            'exercises' => $lesson->exercises->map(fn (Exercise $exercise) => [
                'id' => $exercise->id,
                'type' => $exercise->type,
                'prompt' => $exercise->prompt,
                'hint' => $exercise->hint,
            ])->values(),
        ]);
    }

    public function complete(Request $request, Lesson $lesson): JsonResponse
    {
        UserLessonProgress::updateOrCreate(
            ['user_id' => $request->user()->id, 'lesson_id' => $lesson->id],
            ['completed_at' => now(), 'score' => 100]
        );

        return response()->json(['message' => 'Lección completada.']);
    }

    public function attempt(Request $request, Exercise $exercise): JsonResponse
    {
        $data = $request->validate(['answer' => ['required', 'string', 'max:1000']]);

        $normalize = function (string $value) use ($exercise): string {
            $value = Str::squish(trim($value));
            return $exercise->case_sensitive ? $value : Str::lower($value);
        };

        $correct = $normalize($data['answer']) === $normalize($exercise->expected_answer);

        ExerciseAttempt::create([
            'user_id' => $request->user()->id,
            'exercise_id' => $exercise->id,
            'answer' => $data['answer'],
            'correct' => $correct,
        ]);

        if ($correct) {
            UserLessonProgress::updateOrCreate(
                ['user_id' => $request->user()->id, 'lesson_id' => $exercise->lesson_id],
                ['completed_at' => now(), 'score' => 100]
            );
        }

        return response()->json([
            'correct' => $correct,
            'message' => $correct ? 'Respuesta correcta.' : 'Todavía no. Revisa la pista e inténtalo otra vez.',
            'explanation' => $correct ? $exercise->explanation : $exercise->hint,
            'lesson_completed' => $correct,
        ]);
    }
}
