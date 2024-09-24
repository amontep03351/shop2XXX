<?php

// app/Models/ProductCategoryTranslation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['product_category_id', 'locale', 'name'];
 
    // สร้างความสัมพันธ์กับ ProductCategory
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
