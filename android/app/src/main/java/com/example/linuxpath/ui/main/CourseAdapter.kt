package com.example.linuxpath.ui.main

import android.view.LayoutInflater
import android.view.ViewGroup
import android.widget.ProgressBar
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.linuxpath.R
import com.example.linuxpath.data.model.CourseDto

class CourseAdapter(
    private val onClick: (CourseDto) -> Unit
) : RecyclerView.Adapter<CourseAdapter.Holder>() {
    private val items = mutableListOf<CourseDto>()

    fun submit(newItems: List<CourseDto>) {
        items.clear()
        items.addAll(newItems)
        notifyDataSetChanged()
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): Holder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_course, parent, false)
        return Holder(view as ViewGroup)
    }

    override fun onBindViewHolder(holder: Holder, position: Int) = holder.bind(items[position])
    override fun getItemCount(): Int = items.size

    inner class Holder(private val root: ViewGroup) : RecyclerView.ViewHolder(root) {
        private val level: TextView = root.findViewById(R.id.levelText)
        private val title: TextView = root.findViewById(R.id.titleText)
        private val summary: TextView = root.findViewById(R.id.summaryText)
        private val progress: ProgressBar = root.findViewById(R.id.courseProgress)
        private val progressLabel: TextView = root.findViewById(R.id.progressLabel)

        fun bind(item: CourseDto) {
            level.text = item.level.uppercase()
            title.text = item.title
            summary.text = item.summary
            progress.progress = item.progress_percent
            progressLabel.text = "${item.completed_lessons}/${item.total_lessons} lecciones · ${item.progress_percent}%"
            root.setOnClickListener { onClick(item) }
        }
    }
}
