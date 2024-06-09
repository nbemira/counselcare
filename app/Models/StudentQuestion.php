<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentQuestion extends Model
{
    protected $table = 'student_question';
    protected $fillable = ['ic', 'question_id', 'weightage'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

}
