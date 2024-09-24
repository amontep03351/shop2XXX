<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_image',
        'display_order',
        'status',
        'category_id'
    ];

    /**
     * Get the translations for the product.
     */
    public function translations()
    {
        return $this->hasMany(ProductTranslation::class, 'product_id');
    }

    /**
     * Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
