package com.example.linuxpath.ui.course

import android.content.Intent
import android.os.Bundle
import android.view.View
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.linuxpath.R
import com.example.linuxpath.data.LinuxRepository
import com.example.linuxpath.ui.lesson.LessonActivity
import kotlinx.coroutines.launch

class CourseActivity : AppCompatActivity() {
    private lateinit var repository: LinuxRepository
    private lateinit var adapter: LessonAdapter
    private lateinit var slug: String

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_course)
        repository = LinuxRepository(this)
        slug = intent.getStringExtra("slug") ?: run { finish(); return }

        adapter = LessonAdapter { lesson ->
            startActivity(Intent(this, LessonActivity::class.java).putExtra("lesson_id", lesson.id))
        }
        findViewById<RecyclerView>(R.id.lessonList).apply {
            layoutManager = LinearLayoutManager(this@CourseActivity)
            adapter = this@CourseActivity.adapter
        }
    }

    override fun onResume() {
        super.onResume()
        load()
    }

    private fun load() {
        val loading = findViewById<ProgressBar>(R.id.loading)
        loading.visibility = View.VISIBLE
        lifecycleScope.launch {
            runCatching { repository.course(slug) }
                .onSuccess { course ->
                    findViewById<TextView>(R.id.courseTitle).text = course.title
                    findViewById<TextView>(R.id.courseSummary).text = "${course.summary}\nProgreso: ${course.progress_percent}%"
                    val rows = course.modules.flatMap { module ->
                        module.lessons.map { LessonRow(module.title, it) }
                    }
                    adapter.submit(rows)
                }
                .onFailure {
                    Toast.makeText(this@CourseActivity, "No se pudo cargar el curso.", Toast.LENGTH_LONG).show()
                }
            loading.visibility = View.GONE
        }
    }
}
