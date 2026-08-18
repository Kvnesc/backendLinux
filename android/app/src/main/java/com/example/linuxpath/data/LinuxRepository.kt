package com.example.linuxpath.data

import android.content.Context
import com.example.linuxpath.data.model.*
import com.example.linuxpath.data.network.ApiClient

class LinuxRepository(context: Context) {
    private val api = ApiClient.service(context)
    private val tokenStore = TokenStore(context)

    fun hasSession(): Boolean = !tokenStore.token().isNullOrBlank()

    suspend fun login(email: String, password: String): AuthResponse {
        val response = api.login(
            mapOf(
                "email" to email.trim(),
                "password" to password,
                "device_name" to "Android"
            )
        )
        tokenStore.saveToken(response.token)
        return response
    }

    suspend fun register(name: String, email: String, password: String): AuthResponse {
        val response = api.register(
            mapOf(
                "name" to name.trim(),
                "email" to email.trim(),
                "password" to password,
                "device_name" to "Android"
            )
        )
        tokenStore.saveToken(response.token)
        return response
    }

    suspend fun logout() {
        runCatching { api.logout() }
        tokenStore.clear()
    }

    suspend fun me(): UserDto = api.me()
    suspend fun courses(): List<CourseDto> = api.courses()
    suspend fun course(slug: String): CourseDetailDto = api.course(slug)
    suspend fun lesson(id: Long): LessonDetailDto = api.lesson(id)
    suspend fun completeLesson(id: Long): MessageResponse = api.completeLesson(id)
    suspend fun attemptExercise(id: Long, answer: String): AttemptResponse =
        api.attemptExercise(id, mapOf("answer" to answer))
    suspend fun progress(): ProgressResponse = api.progress()
}
