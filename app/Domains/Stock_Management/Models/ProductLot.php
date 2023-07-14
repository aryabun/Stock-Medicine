<?php

namespace App\Domains\Stock_Management\Models;

use App\Traits\BasicFilter;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Stock_Management\Models\ProductBox;
use App\Domains\Stock_Management\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class ProductLot extends Model
{
    use HasFactory, SoftDeletes, Searchable, BasicFilter;
    protected $fillable = [
        'lot_code',
        'warehouse_code',

    ];
    public $keyType = 'string';
    public $primaryKey = 'lot_code';
    public $incrementing = false;
    protected $table = 'product_lots';

    public function warehouse()
    {
        # code...
        return $this->belongsTo(Warehouse::class, 'warehouse_code', 'warehouse_code');
    }
    public function box()
    {
        # code...
        return $this->hasMany(ProductBox::class, 'lot_code', 'lot_code');
    }
    public function product()
    {
        # code...
        return $this->hasMany(Product::class, 'product_code');
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function (ProductLot $model) {  
            $model->lot_code = IdGenerator::generate(['table' => 'product_lots','field' =>'lot_code', 'length' => 7, 'prefix' => 'Lot']);
        });
    }
}
