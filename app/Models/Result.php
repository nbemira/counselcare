<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    protected $fillable = ['ic', 'marks_d', 'marks_a', 'marks_s', 'status', 'assessment_round'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'ic', 'ic');
    }

}
