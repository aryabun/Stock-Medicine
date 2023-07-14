<?php

namespace App\Domains\Stock_Management\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferProducts extends Model
{
    use HasFactory;
    protected $fillable = [
        'transfer_id',
        'qty',
        'box_code',
        'price',
        'product_code',
        'unit',
    ];
    protected $table = 'transfer_products';
    public function transfer()
    {
        return $this->belongsTo(Transfer::class, 'transfer_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_code');
    }
    public function box()
    {
        return $this->belongsTo(ProductBox::class, 'box_code');
    }
}
