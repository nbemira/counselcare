<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category'; // Set the table name

    protected $primaryKey = 'category_id'; // Set the primary key field

    public $incrementing = false; // Assuming 'category_id' is not auto-incrementing

    protected $fillable = [
        'category_id',
        'category',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'category_id');
    }

}
