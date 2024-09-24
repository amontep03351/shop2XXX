<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    // Define the table name if it's not following Laravel's naming convention
    protected $table = 'contact_us';

    // Define which attributes are mass assignable
    protected $fillable = [
        'address_en', 
        'address_th', 
        'mail', 
        'tel', 
        'linkfacebook', 
        'linkyoutube', 
        'maplocation'
    ];

    // If you want to automatically cast JSON fields back to arrays
    protected $casts = [
        'mail' => 'array',
        'tel' => 'array',
    ];
}
