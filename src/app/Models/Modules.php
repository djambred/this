<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;
    protected $table = 'modules';
    protected $fillable = [
        'title',
        'description',
        'link',
        'course_id',
    ];
    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'link' => 'string',
        'course_id' => 'integer',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
