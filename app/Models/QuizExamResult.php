<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizExamResult extends Model
{
    use HasFactory;

    protected $table = 'quiz_exam_results';

    protected $fillable = [
        'quiz_exam_id',
        'user_id',
        'results',
        'point',
        'total_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
