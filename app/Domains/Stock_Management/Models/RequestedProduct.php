<?php

namespace App\Domains\Stock_Management\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestedProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_id',
        'product_code',
        'qty',
        'unit'
    ];
    protected $table = 'requested_products';
    public function request_transfers()
    {
        return $this->belongsTo(RequestTransfer::class, 'request_id');
    }
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_code', 'product_code');
    }
}
