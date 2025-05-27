<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedules';
    protected $fillable = [
        'batch_id',
        'start_time',
        'end_time',
        'location',
    ];
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function modules()
    {
        return $this->belongsTo(Modules::class);
    }
}
