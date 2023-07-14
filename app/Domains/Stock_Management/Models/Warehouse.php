<?php

namespace App\Domains\Stock_Management\Models;

use App\Domains\Backend\Models\Commune;
use App\Domains\Backend\Models\District;
use App\Domains\Backend\Models\Province;
use App\Domains\Backend\Models\Village;
use App\Domains\Stock_Management\Models\ProductLot;
use App\Traits\BasicFilter;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Warehouse extends Model
{
    use HasFactory,SoftDeletes, Searchable, BasicFilter;
    protected $fillable = [
        'warehouse_code',
        'warehouse_name',
        'hospital_id',
        'level',
        'province_id',
        'district_id',
        'commune_id',
        'village_id',
        'address',
    ];
    public $keyType = 'string';
    public $primaryKey = 'warehouse_code';
    public $incrementing = false;
    protected $table = 'warehouses';
    public function lots()
    {
        return $this->hasMany(ProductLot::class, 'warehouse_code','warehouse_code');
    }
    public function province(){
        return $this->hasMany(Province::class,'id','province_id');
    }
    public function district(){
        return $this->hasMany(District::class,'id', 'district_id');
    }
    public function commune(){
        return $this->hasMany(Commune::class,'id', 'commune_id');
    }
    public function village(){
        return $this->hasMany(Village::class,'id', 'village_id');
    }
}
