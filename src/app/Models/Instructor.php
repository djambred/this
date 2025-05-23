<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $table = 'instructors';
    protected $fillable = [
        'user_id',
        'instructor_id',
        'phone',
        'bio',
        'expertise',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'instructor_id' => 'string',
        'phone' => 'string',
        'bio' => 'string',
        'expertise' => 'string',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
