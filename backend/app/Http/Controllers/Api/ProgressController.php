<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\UserLessonProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $total = Lesson::count();
        $completed = UserLessonProgress::where('user_id', $request->user()->id)
            ->whereNotNull('completed_at')
            ->distinct('lesson_id')
            ->count('lesson_id');

        return response()->json([
            'completed_lessons' => $completed,
            'total_lessons' => $total,
            'progress_percent' => $total > 0 ? (int) round(($completed / $total) * 100) : 0,
        ]);
    }
}
