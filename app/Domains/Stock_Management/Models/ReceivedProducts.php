<?php

namespace App\Domains\Stock_Management\Models;

use App\Domains\Stock_Management\Models\Received;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedProducts extends Model
{
    use HasFactory;
    protected $fillable = [
       'received_id',
       'product_code',
       'qty',
       'unit',
    ];
    protected $table = 'received_products';

    public function received(){
        return $this->belongsTo(Received::class, 'received_id');
    }
}
