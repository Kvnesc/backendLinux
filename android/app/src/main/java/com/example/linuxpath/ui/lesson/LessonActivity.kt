package com.example.linuxpath.ui.lesson

import android.os.Bundle
import android.view.View
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import com.example.linuxpath.R
import com.example.linuxpath.data.LinuxRepository
import com.example.linuxpath.data.model.ExerciseDto
import kotlinx.coroutines.launch

class LessonActivity : AppCompatActivity() {
    private lateinit var repository: LinuxRepository
    private var lessonId: Long = -1
    private var exercise: ExerciseDto? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_lesson)
        repository = LinuxRepository(this)
        lessonId = intent.getLongExtra("lesson_id", -1)
        if (lessonId < 0) { finish(); return }

        findViewById<Button>(R.id.checkButton).setOnClickListener { checkAnswer() }
        findViewById<Button>(R.id.completeButton).setOnClickListener { completeLesson() }
        load()
    }

    private fun load() {
        setLoading(true)
        lifecycleScope.launch {
            runCatching { repository.lesson(lessonId) }
                .onSuccess { lesson ->
                    findViewById<TextView>(R.id.lessonTitle).text = lesson.title
                    findViewById<TextView>(R.id.lessonContent).text = lesson.content
                    findViewById<TextView>(R.id.commandExample).apply {
                        if (lesson.command_example.isNullOrBlank()) {
                            visibility = View.GONE
                        } else {
                            text = lesson.command_example
                            visibility = View.VISIBLE
                        }
                    }
                    exercise = lesson.exercises.firstOrNull()
                    findViewById<TextView>(R.id.exercisePrompt).text = exercise?.let {
                        "Práctica\n${it.prompt}${it.hint?.let { h -> "\nPista: $h" } ?: ""}"
                    } ?: "Esta lección no tiene ejercicio."
                    findViewById<EditText>(R.id.answerInput).visibility = if (exercise != null) View.VISIBLE else View.GONE
                    findViewById<Button>(R.id.checkButton).visibility = if (exercise != null) View.VISIBLE else View.GONE
                    findViewById<TextView>(R.id.resultText).text = if (lesson.completed) "✓ Lección completada" else ""
                }
                .onFailure {
                    Toast.makeText(this@LessonActivity, "No se pudo cargar la lección.", Toast.LENGTH_LONG).show()
                }
            setLoading(false)
        }
    }

    private fun checkAnswer() {
        val current = exercise ?: return
        val answer = findViewById<EditText>(R.id.answerInput).text.toString()
        if (answer.isBlank()) return
        setLoading(true)
        lifecycleScope.launch {
            runCatching { repository.attemptExercise(current.id, answer) }
                .onSuccess { result ->
                    findViewById<TextView>(R.id.resultText).text = buildString {
                        append(if (result.correct) "✓ " else "✗ ")
                        append(result.message)
                        result.explanation?.takeIf { it.isNotBlank() }?.let { append("\n").append(it) }
                    }
                }
                .onFailure {
                    findViewById<TextView>(R.id.resultText).text = "No se pudo comprobar la respuesta."
                }
            setLoading(false)
        }
    }

    private fun completeLesson() {
        setLoading(true)
        lifecycleScope.launch {
            runCatching { repository.completeLesson(lessonId) }
                .onSuccess { findViewById<TextView>(R.id.resultText).text = "✓ Lección completada" }
                .onFailure { Toast.makeText(this@LessonActivity, "No se pudo guardar el progreso.", Toast.LENGTH_LONG).show() }
            setLoading(false)
        }
    }

    private fun setLoading(value: Boolean) {
        findViewById<ProgressBar>(R.id.loading).visibility = if (value) View.VISIBLE else View.GONE
    }
}
