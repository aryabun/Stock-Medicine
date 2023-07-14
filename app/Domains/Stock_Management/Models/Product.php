<?php
namespace App\Domains\Stock_Management\Models;

use App\Domains\Stock_Management\Models\ProductVariant;
use App\Domains\Stock_Management\Models\ProductPrice;
use App\Traits\BasicFilter;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory,SoftDeletes, Searchable, BasicFilter;
    protected $fillable = [
        'product_code',
        'product_name',
        'description',
        'unit',//bottle or tablet
        'strength',
        'med_type',
        'disease_type',
        'image',
        'status', // true if available stock
            
    ];
    public $keyType = 'string';
    public $primaryKey = 'product_code';
    public $incrementing = false;
    // public $primaryKey = 'product_code';
    protected $table = "products";
    /**
     * Get all of the variant for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variant()
    {
        return $this->hasMany(ProductVariant::class, 'product_code', 'product_code');
    }
    public function stock()
    {
        return $this->hasOne(StockData::class, 'product_code', 'product_code');
    }
    public function prices()
    { 
        return $this->hasMany(ProductPrice::class, 'product_code', 'product_code');
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function (Product $model) {  
            $model->product_code = IdGenerator::generate(['table' => 'products','field' =>'product_code', 'length' => 6, 'prefix' => 'P']);
        });
    }
    public function toSearchableArray(): array
    {
        return[
            'product_code' => $this->product_code,
            'product_name' => $this->product_name,
            'strength' => $this->strength,
            'med_type' => $this->med_type,
            'disease_type' => $this->disease_type,
        ];
    }
}
