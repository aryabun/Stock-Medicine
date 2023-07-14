<?php

namespace App\Domains\Stock_Management\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantAttributeValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'attribute_id',
        'value',
        'status',
        
    ];
    protected $table = 'product_variant_attribute_value';
    public function product_variant()
    {
        # code...
        return $this->belongsTo(ProductVariant::class, 'id', 'value_id');
    }
    public function attribute()
    {
        # code...
        return $this->belongsTo(ProductVariantAttribute::class, 'attribute_id', 'id');
    }
}
