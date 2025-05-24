<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Assessment extends Model
{
    use HasFactory;
    protected $table = 'assessments';
    protected $fillable = [
        'github_repository',
        'score',
        'status',
        'student_id',
        'modules_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function modules()
    {
        return $this->belongsTo(Modules::class);
    }
}
