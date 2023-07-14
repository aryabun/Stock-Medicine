<?php

namespace App\Domains\Stock_Management\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class ProductPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id',
        'product_code',
        'value'
    ];
    
    protected $table = 'product_prices';
    public function product()
    {
        # code...
        return $this->belongsTo(Product::class, 'product_code');
    }
    public function role(){
        return $this->hasMany(SpatieRole::class, 'id','role_id')->select('type', 'name');
    }
}
