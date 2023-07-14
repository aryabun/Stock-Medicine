<?php

namespace App\Domains\Stock_Management\Models;

use App\Traits\BasicFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockData extends Model
{
    use HasFactory, BasicFilter;
    protected $fillable = [
        'product_code',
        'current_stock'
    ];
    protected $table = 'stock';
    public function product()
    {
       return $this->hasMany(Product::class, 'product_code', 'product_code');
    }
    public function box()
    {
       return $this->hasMany(ProductBox::class, 'product_code', 'product_code');
    }
}
