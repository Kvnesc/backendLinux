package com.example.linuxpath.ui.main

import android.content.Intent
import android.os.Bundle
import android.view.View
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.linuxpath.R
import com.example.linuxpath.data.LinuxRepository
import com.example.linuxpath.ui.auth.AuthActivity
import com.example.linuxpath.ui.course.CourseActivity
import kotlinx.coroutines.async
import kotlinx.coroutines.launch

class MainActivity : AppCompatActivity() {
    private lateinit var repository: LinuxRepository
    private lateinit var adapter: CourseAdapter
    private lateinit var loading: ProgressBar
    private lateinit var greeting: TextView
    private lateinit var progressText: TextView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
        repository = LinuxRepository(this)

        loading = findViewById(R.id.loading)
        greeting = findViewById(R.id.greetingText)
        progressText = findViewById(R.id.progressText)

        adapter = CourseAdapter { course ->
            startActivity(Intent(this, CourseActivity::class.java).putExtra("slug", course.slug))
        }
        findViewById<RecyclerView>(R.id.courseList).apply {
            layoutManager = LinearLayoutManager(this@MainActivity)
            adapter = this@MainActivity.adapter
        }

        findViewById<Button>(R.id.logoutButton).setOnClickListener {
            lifecycleScope.launch {
                repository.logout()
                startActivity(Intent(this@MainActivity, AuthActivity::class.java))
                finishAffinity()
            }
        }
    }

    override fun onResume() {
        super.onResume()
        load()
    }

    private fun load() {
        loading.visibility = View.VISIBLE
        lifecycleScope.launch {
            val userTask = async { runCatching { repository.me() }.getOrNull() }
            val progressTask = async { runCatching { repository.progress() }.getOrNull() }
            val coursesTask = async { runCatching { repository.courses() } }

            val user = userTask.await()
            val progress = progressTask.await()
            val courses = coursesTask.await()

            greeting.text = if (user != null) "Hola, ${user.name}" else "Tu ruta Linux"
            progressText.text = progress?.let {
                "Progreso total: ${it.completed_lessons}/${it.total_lessons} lecciones (${it.progress_percent}%)"
            } ?: "Aprende a tu ritmo"

            courses.onSuccess(adapter::submit)
                .onFailure {
                    Toast.makeText(this@MainActivity, "No se pudieron cargar los cursos.", Toast.LENGTH_LONG).show()
                }
            loading.visibility = View.GONE
        }
    }
}
