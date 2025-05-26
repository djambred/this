<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'user_id',
        'batch_id',
        'amount',
        'status',
    ];
    protected $casts = [
        'amount' => 'integer',
        'status' => 'string',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'success' => 'Success',
            'failed' => 'Failed',
            default => 'Unknown',
        };
    }
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'success' => 'success',
            'failed' => 'danger',
            default => 'secondary',
        };
    }
    public function getAmountFormattedAttribute()
    {
        return number_format($this->amount, 0, ',', '.');
    }

}
