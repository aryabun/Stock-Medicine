<?php

namespace App\Domains\Stock_Management\Models;

use App\Domains\Internal\Models\InternalAdmin;
use App\Domains\Stock_Management\Models\RequestedProduct;
use App\Traits\BasicFilter;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class RequestTransfer extends Model
{
    use HasFactory, Searchable, BasicFilter;
    protected $fillable = [
        'request_id',
        'user_id',
        'from_warehouse', //take ID
        'to_warehouse', //Take ID
        'approved_by',
        'approved_date',
        'rejected_by',
        'rejected_date',
        'schedule_date',
        'eta', //expected transfer arrive, type date
        'status',
        'transfer_ref',
        'received_by',
        'received_date',
        'received_ref',
    ];
    protected $casts = [
        'approved_date' => 'datetime:Y-m-d',
        'rejected_date' => 'datetime:Y-m-d',
        'schedule_date' => 'datetime:Y-m-d',
        'eta' => 'datetime:Y-m-d',
        'received_date' => 'datetime:Y-m-d',
    ];
    public $keyType = 'string';
    public $primaryKey = 'request_id';
    public $incrementing = false;
    protected $table = 'request_transfers';
    public function requested_products()
    {
        # code...
        return $this->hasMany(RequestedProduct::class, 'request_id');
    }
    public function transfer()
    {
        return $this->belongsTo(Transfers::class, 'request_id');
    }
    public function approver()
    {
        return $this->belongsTo(InternalAdmin::class,'approved_by', 'code');
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function (RequestTransfer $model) {
            $prefix = "RT-".date("y")."-".date("m")."-";
            $length = strlen($prefix) + 4; // count length of prefix and plus 4 because '0001' and so on
            $model->request_id = IdGenerator::generate(['table' => 'request_transfers','field' =>'request_id', 'length' => $length, 'prefix' => $prefix]);
        });
    }
}
