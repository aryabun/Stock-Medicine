<?php

namespace App\Domains\Stock_Management\Models;

use App\Domains\Stock_Management\Models\ProductVariantAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'product_code' ,
        'attribute_id', 
        'value_id', 
        'created_by',
    ];
    protected $table = 'product_variants';
    public function product():BelongsTo
    {
        # code...
        return $this->belongsTo(Product::class, 'product_code','product_code');
    }
    public function attribute():HasMany
    {
        # code...
        return $this->hasMany(ProductVariantAttribute::class, 'id', 'attribute_id');
    }
    public function value():HasMany
    {
        # code...
        return $this->hasMany(ProductVariantAttributeValue::class, 'id','value_id');
    }
}
