<?php

namespace App\Domains\Stock_Management\Models;

use App\Domains\Stock_Management\Models\Product;
use App\Domains\Stock_Management\Models\ProductLot;
use App\Traits\BasicFilter;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class ProductBox extends Model
{
    use HasFactory, SoftDeletes, Searchable, BasicFilter;
    protected $fillable = [
        'box_code',
        'product_code',
        'lot_code',
        'bottle_qty',
        'qty_per_bottle',
        'unit',
        'status',
        'exp_date',
    ];
    public $keyType = 'string';
    public $primaryKey = 'box_code';
    public $incrementing = false;
    protected $casts = [
        'exp_date' => 'date:Y-m-d',
    ];
    protected $table = 'product_boxes';
    public function product():HasMany
    {
        # code...
        return $this->hasMany(Product::class, 'product_code','product_code');
    }
    public function lot()
    {
        # code...
        return $this->hasMany(ProductLot::class, 'lot_code','lot_code');
    }
    public function transferBox()
    {
        # code...
        return $this->hasMany(TransferProducts::class, 'box_code');
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function (ProductBox $model) {  
            $model->box_code = IdGenerator::generate(['table' => 'product_boxes','field' =>'box_code', 'length' => 5, 'prefix' => 'B']);
        });
        self::saving(function(ProductBox $model){
            if($model->bottle_qty > 0){
                $model->status = true;
            }else{
                $model->status = false;
            }
        });
    }
    public function toSearchableArray(): array
    {
        return[
            'box_code' => $this->box_code,
            'product_code' => $this->product_code,
            'product_name' => $this->product()->product_name,
            'lot_code' => $this->lot_code,
            'qty_per_bottle' => $this->qty_per_bottle,
            'exp_date' => $this->exp_date,
        ];
    }
}
