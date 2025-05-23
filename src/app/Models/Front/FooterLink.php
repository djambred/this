<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;
    protected $table = 'footer_links';
    protected $fillable =[
        'section',
        'url',
        'label',
        'service',
        'order'
    ];
}
