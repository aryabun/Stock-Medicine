<?php

namespace App\Domains\Stock_Management\Models;

use App\Domains\Stock_Management\Models\ReceivedProducts;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Received extends Model
{
    use HasFactory;
    protected $fillable = [
        'received_id',
        'transfer_id',
        'received_user',
        'received_date',
        'total_price',
    ];
    protected $casts = [
        'received_date' => 'datetime:Y-m-d',
    ];
    public $keyType = 'string';
    public $primaryKey = 'received_id';
    public $incrementing = false;
    protected $table = 'receiveds';
    public static function boot()
    {
        parent::boot();
        self::creating(function (Received $model) {
            $prefix = "INV-".date("y")."-".date("m")."-";
            $length = strlen($prefix) + 6; // count length of prefix and plus 4 because '0001' and so on
            $model->received_id = IdGenerator::generate(['table' => 'receiveds','field' =>'received_id', 'length' => $length, 'prefix' => $prefix]);
        });
    }
    public function receive_products(){
        return $this->hasMany(ReceivedProducts::class, 'received_id');
    }
}
