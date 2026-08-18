package com.example.linuxpath.data.network

import com.example.linuxpath.data.model.*
import retrofit2.http.*

interface ApiService {
    @POST("auth/register")
    suspend fun register(@Body body: Map<String, String>): AuthResponse

    @POST("auth/login")
    suspend fun login(@Body body: Map<String, String>): AuthResponse

    @POST("auth/logout")
    suspend fun logout(): MessageResponse

    @GET("me")
    suspend fun me(): UserDto

    @GET("courses")
    suspend fun courses(): List<CourseDto>

    @GET("courses/{slug}")
    suspend fun course(@Path("slug") slug: String): CourseDetailDto

    @GET("lessons/{id}")
    suspend fun lesson(@Path("id") id: Long): LessonDetailDto

    @POST("lessons/{id}/complete")
    suspend fun completeLesson(@Path("id") id: Long): MessageResponse

    @POST("exercises/{id}/attempt")
    suspend fun attemptExercise(
        @Path("id") id: Long,
        @Body body: Map<String, String>
    ): AttemptResponse

    @GET("progress")
    suspend fun progress(): ProgressResponse
}
