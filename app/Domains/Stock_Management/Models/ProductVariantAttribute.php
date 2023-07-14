<?php

namespace App\Domains\Stock_Management\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariantAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'attribute',
    ];
    protected $table = 'product_variant_attribute';
    public function product_variant():BelongsTo
    {
        # code...
        return $this->belongsTo(ProductVariant::class);
    }
    public function value()
    {
        # code...
        return $this->hasMany(ProductVariantAttributeValue::class, 'attribute_id', 'id');
    }
}
