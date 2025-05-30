<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    protected $table = 'batches';
    protected $fillable = [
        'name',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
