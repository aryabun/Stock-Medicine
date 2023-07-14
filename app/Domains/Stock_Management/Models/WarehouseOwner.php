<?php

namespace App\Domains\Stock_Management\Models;

use App\Domains\External\Models\ExternalAdmin;
use App\Domains\Internal\Models\InternalAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseOwner extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_code',
        'user_id',
    ];
    protected $table = 'warehouse_owners';

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_code', 'warehouse_code');
    }
    public function external_owner()
    {
        # code...
        return $this->hasMany(ExternalAdmin::class, 'user_id', 'code');
    }
    public function internal_owner()
    {
        # code...
        return $this->hasMany(InternalAdmin::class, 'user_id', 'code');
    }
}
