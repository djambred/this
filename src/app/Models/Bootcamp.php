<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bootcamp extends Model
{
    protected $table = 'bootcamps';
    protected $fillable = [
        'batch_id',
        'course_id',

    ];

    // Relationships
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function modules()
    {
        return $this->hasMany(Modules::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
