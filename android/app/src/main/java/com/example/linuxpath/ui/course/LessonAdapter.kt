package com.example.linuxpath.ui.course

import android.view.LayoutInflater
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.linuxpath.R
import com.example.linuxpath.data.model.LessonSummaryDto

 data class LessonRow(val moduleTitle: String, val lesson: LessonSummaryDto)

class LessonAdapter(
    private val onClick: (LessonSummaryDto) -> Unit
) : RecyclerView.Adapter<LessonAdapter.Holder>() {
    private val items = mutableListOf<LessonRow>()

    fun submit(rows: List<LessonRow>) {
        items.clear()
        items.addAll(rows)
        notifyDataSetChanged()
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): Holder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_lesson, parent, false)
        return Holder(view as ViewGroup)
    }

    override fun onBindViewHolder(holder: Holder, position: Int) = holder.bind(items[position])
    override fun getItemCount(): Int = items.size

    inner class Holder(private val root: ViewGroup) : RecyclerView.ViewHolder(root) {
        private val moduleText: TextView = root.findViewById(R.id.moduleText)
        private val titleText: TextView = root.findViewById(R.id.titleText)
        private val statusText: TextView = root.findViewById(R.id.statusText)

        fun bind(row: LessonRow) {
            moduleText.text = row.moduleTitle
            titleText.text = row.lesson.title
            statusText.text = if (row.lesson.completed) {
                "✓ Completada · ${row.lesson.estimated_minutes} min"
            } else {
                "Pendiente · ${row.lesson.estimated_minutes} min"
            }
            root.setOnClickListener { onClick(row.lesson) }
        }
    }
}
