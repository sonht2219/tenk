<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LotterySession.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property int $product_id
 * @property int|null $time_end
 * @property int $sold_quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status 1: Đang bán. 2: Đang đếm ngược. 3: Kết thúc. -1: Đã xóa.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lottery[] $lotteries
 * @property-read int|null $lotteries_count
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession whereSoldQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession whereTimeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotterySession whereUpdatedAt($value)
 * @mixin \Eloquent
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
