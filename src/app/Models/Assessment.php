<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Assessment extends Model
{
    use HasFactory;
    protected $table = 'assessments';
    protected $fillable = [
        'name',
        'description',
        'bootcamp_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modules()
    {
        return $this->belongsTo(Modules::class);
    }

    public function bootcamp()
    {
        return $this->belongsTo(Bootcamp::class);
    }
}
