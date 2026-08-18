<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseAttempt extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'exercise_id', 'answer', 'correct'];
    protected function casts(): array { return ['correct' => 'boolean']; }
    public function user() { return $this->belongsTo(User::class); }
    public function exercise() { return $this->belongsTo(Exercise::class); }
}
