<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\StudentResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'student';
    
    protected $primaryKey = 'ic';

    protected $fillable = [
        'ic',
        'name',
        'password',
        'email',
        'gender',
        'pass_status',
        'remember_token',
        'created_at',
        'updated_at',
        'pass_status'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'ic' => 'string',
    ];

    /**
     * Get the name of the unique identifier for the student.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'ic';
    }

    /**
     * Get the unique identifier for the student.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getAttribute('ic');
    }

    /**
     * Get the password for the student.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->getAttribute('password');
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->getAttribute('remember_token');
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->setAttribute('remember_token', $value);
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'ic', 'ic');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StudentResetPasswordNotification($token));
    }

}
