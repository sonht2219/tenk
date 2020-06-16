<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LotterySession.
 *
 * @package namespace App\Models;
 */
class LotterySession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'status',
        'time_end'
    ];

    public function lotteries() {
        return $this->hasMany(Lottery::class, 'session_id');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
