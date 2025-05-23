<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageConfig extends Model
{
    use HasFactory;
    protected $table = 'page_configs';
    protected $fillable =[
        'title',
        'url',
        'description',
        'image',
        'description_services',
        'detail_services',
        'name_services'
    ];
}
