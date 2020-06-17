<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property int $session_id
 * @property string $user_id
 * @property int $product_id
 * @property int $lottery_id
 * @property string $content
 * @property string|null $images
 * @property int $status 1: Hoạt động. -1: Không hoạt động.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Lottery $lottery
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\LotterySession $session
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereLotteryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereUserId($value)
 * @mixin \Eloquent
 */
class Feedback extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'images',
        'user_id',
        'session_id',
        'lottery_id',
        'product_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(LotterySession::class, 'session_id');
    }

    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
