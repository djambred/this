<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'instructor_id',
    ];
    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'image' => 'string',
        'link' => 'string',
        'instructor_id' => 'integer',
    ];
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    public function modules()
    {
        return $this->hasMany(Modules::class);
    }
    public function batch(){
        return $this->belongsTo(Batch::class);
    }

}
