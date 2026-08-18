<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = ['lesson_id', 'type', 'prompt', 'expected_answer', 'case_sensitive', 'hint', 'explanation', 'position'];
    protected function casts(): array { return ['case_sensitive' => 'boolean']; }
    public function lesson() { return $this->belongsTo(Lesson::class); }
}
