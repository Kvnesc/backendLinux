<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\UserLessonProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $completedIds = UserLessonProgress::where('user_id', $request->user()->id)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id')
            ->all();

        $courses = Course::with('modules.lessons:id,module_id')
            ->orderBy('position')
            ->get()
            ->map(function (Course $course) use ($completedIds) {
                $lessonIds = $course->modules->flatMap(fn ($module) => $module->lessons)->pluck('id');
                $total = $lessonIds->count();
                $completed = $lessonIds->intersect($completedIds)->count();

                return [
                    'id' => $course->id,
                    'slug' => $course->slug,
                    'title' => $course->title,
                    'summary' => $course->summary,
                    'level' => $course->level,
                    'position' => $course->position,
                    'total_lessons' => $total,
                    'completed_lessons' => $completed,
                    'progress_percent' => $total > 0 ? (int) round(($completed / $total) * 100) : 0,
                ];
            });

        return response()->json($courses);
    }

    public function show(Request $request, Course $course): JsonResponse
    {
        $course->load('modules.lessons');
        $completedIds = UserLessonProgress::where('user_id', $request->user()->id)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id');

        $allLessonIds = $course->modules->flatMap(fn ($module) => $module->lessons)->pluck('id');
        $total = $allLessonIds->count();
        $completed = $allLessonIds->intersect($completedIds)->count();

        return response()->json([
            'id' => $course->id,
            'slug' => $course->slug,
            'title' => $course->title,
            'summary' => $course->summary,
            'level' => $course->level,
            'progress_percent' => $total > 0 ? (int) round(($completed / $total) * 100) : 0,
            'modules' => $course->modules->map(fn ($module) => [
                'id' => $module->id,
                'title' => $module->title,
                'position' => $module->position,
                'lessons' => $module->lessons->map(fn ($lesson) => [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'position' => $lesson->position,
                    'estimated_minutes' => $lesson->estimated_minutes,
                    'completed' => $completedIds->contains($lesson->id),
                ])->values(),
            ])->values(),
        ]);
    }
}
