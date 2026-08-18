package com.example.linuxpath.data.model

data class UserDto(
    val id: Long,
    val name: String,
    val email: String
)

data class AuthResponse(
    val token: String,
    val user: UserDto
)

data class CourseDto(
    val id: Long,
    val slug: String,
    val title: String,
    val summary: String,
    val level: String,
    val position: Int,
    val total_lessons: Int,
    val completed_lessons: Int,
    val progress_percent: Int
)

data class CourseDetailDto(
    val id: Long,
    val slug: String,
    val title: String,
    val summary: String,
    val level: String,
    val progress_percent: Int,
    val modules: List<ModuleDto>
)

data class ModuleDto(
    val id: Long,
    val title: String,
    val position: Int,
    val lessons: List<LessonSummaryDto>
)

data class LessonSummaryDto(
    val id: Long,
    val title: String,
    val position: Int,
    val estimated_minutes: Int,
    val completed: Boolean
)

data class LessonDetailDto(
    val id: Long,
    val title: String,
    val content: String,
    val command_example: String?,
    val estimated_minutes: Int,
    val completed: Boolean,
    val exercises: List<ExerciseDto>
)

data class ExerciseDto(
    val id: Long,
    val type: String,
    val prompt: String,
    val hint: String?
)

data class AttemptResponse(
    val correct: Boolean,
    val message: String,
    val explanation: String?,
    val lesson_completed: Boolean
)

data class ProgressResponse(
    val completed_lessons: Int,
    val total_lessons: Int,
    val progress_percent: Int
)

data class MessageResponse(val message: String)
