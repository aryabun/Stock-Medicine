<?php

namespace App\Domains\Stock_Management\Models;

use App\Domains\External\Models\ExternalAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['status', 'description', 'data'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->user()->code;
        });
    }

    /**
     * Get the owning statusable model.
     */
    public function statusable()
    {
        return $this->morphTo();
    }

    /**
     * Get the creator of statusable model.
     */
    public function creator()
    {
        return $this->belongsTo(ExternalAdmin::class, 'created_by');
    }
}
