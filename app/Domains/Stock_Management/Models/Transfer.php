<?php

namespace App\Domains\Stock_Management\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Internal\Models\InternalAdmin;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'transfer_id',
        'request_id',
        'contact_id',
        'from_warehouse',
        'to_warehouse',
        'approved_by',
        'approved_date',
        'schedule_date',
        'eta',
        'status',
        'total_price',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    public $keyType = 'string';
    public $primaryKey = 'transfer_id';
    public $incrementing = false;
    protected $table = 'transfers';

    public static function boot()
    {
        parent::boot();
        self::creating(function (Transfer $model) {
            $prefix = "TF-".date("y")."-".date("m")."-";
            $length = strlen($prefix) + 4; // count length of prefix and plus 4 because '0001' and so on
            $model->transfer_id = IdGenerator::generate(['table' => 'transfers','field' =>'transfer_id', 'length' => $length, 'prefix' => $prefix]);
        });
    }
    public function trans_products()
    {
        return $this->hasMany(TransferProducts::class, 'transfer_id');
    }
    public function approver()
    {
        return $this->belongsTo(InternalAdmin::class,'approved_by', 'code');
    }

    public function box_movement()
    {
        return $this->hasOne(ProductBox::class, 'box_code');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'product_code');
    }
    public function req_tranfer()
    {
        return $this->hasOne(RequestTransfer::class, 'request_id');
    }

}
