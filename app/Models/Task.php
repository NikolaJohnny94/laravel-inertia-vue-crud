<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'category', 'finished', 'user_id', 'slug'];

    use HasFactory;

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            $task->slug = Str::slug($task->title);
        });

        static::updating(function ($task) {
            $task->slug = Str::slug($task->title);
        });
    }
}
