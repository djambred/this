<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
    public function modules()
    {
        return $this->hasMany(Modules::class);
    }
    public function batches(){
        return $this->hasMany(Batch::class);
    }
    public function bootcamp()
    {
        return $this->belongsTo(Bootcamp::class);
    }

}
