<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = ['module_id', 'title', 'content', 'command_example', 'estimated_minutes', 'position'];
    public function module() { return $this->belongsTo(Module::class); }
    public function exercises() { return $this->hasMany(Exercise::class)->orderBy('position'); }
}
