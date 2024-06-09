<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions'; // Set the table name

    protected $primaryKey = 'id'; // Set the primary key field

    public $incrementing = false; // Assuming 'category_id' is not auto-incrementing

    protected $fillable = [
        'id',
        'question',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function studentQuestions()
    {
        return $this->hasMany(StudentQuestion::class, 'question_id');
    }

}
