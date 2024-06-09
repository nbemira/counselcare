<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Intervention extends Model
{
    use HasFactory;

    protected $table = 'interventions';
    protected $primaryKey = 'id';
    protected $fillable = ['ic', 'intervention_appt', 'sec_assessment_approval'];

    protected $casts = [
        'intervention_appt' => 'datetime:Y-m-d',
    ];
    
    public function result()
    {
        return $this->belongsTo(Result::class, 'ic', 'ic');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'ic', 'ic');
    }
}
