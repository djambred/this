<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = [
        //'product_id',
        'user_id',
        'student_id',
        'student_origin',
        'phone',
        'address',
        'github_name',
        'github_url',
        'midtrans_result',
    ];
    protected $casts = [
        //'product_id' => 'integer',
        'user_id' => 'integer',
        'student_id' => 'string',
        'student_origin' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'github_name' => 'string',
        'github_url' => 'string',
        'midtrans_result' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function batches()
    {
        return $this->belongsTo(Batch::class);
    }
}
