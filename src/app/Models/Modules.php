<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;
    protected $table = 'modules';
    protected $fillable = [
        'name',
        'video',
        'file',
        'course_id',
        'bootcamp_id',
        'instructor_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function instructors()
    {
        return $this->belongsToMany(User::class);
    }
    public function bootcamp()
    {
        return $this->belongsTo(Bootcamp::class);
    }
}
