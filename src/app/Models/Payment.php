<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
