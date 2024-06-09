<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psychologist extends Model
{
    protected $table = 'psychologists';
    protected $primaryKey = 'id';

    protected $fillable = [
        'icon',
        'name',
        'qualifications',
        'specialization',
        'email',
        'phone',
        'location',
        'availability'
    ];

    public static function getPsychologistList()
    {
        return self::all();
    }

}
