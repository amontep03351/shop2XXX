<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    protected $table = 'aboutus';

    protected $fillable = [ 
        'title_en',
        'title_th',
        'description_en', 
        'description_th', 
        'image',  
    ];
}
