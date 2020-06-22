<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Models\LotteryReward
 *
 * @property int $id
 * @property int $session_id
 * @property string $user_id
 * @property int $lottery_id
 * @property int $join_times Số lần tham dự
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status 1: Processing. 2: Shipping. 3: Done. -1: Rejected.
 * @property-read \App\Models\Lottery $lottery
 * @property-read \App\Models\LotterySession $session
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward whereJoinTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward whereLotteryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryReward whereUserId($value)
 * @mixin \Eloquent
 */
class LotteryReward extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_id',
        'lottery_id',
        'user_id',
        'join_times',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lottery() {
        return $this->belongsTo(Lottery::class);
    }

    public function session() {
        return $this->belongsTo(LotterySession::class, 'session_id');
    }

    public function info() {
        return $this->hasOne(LotteryRewardInfo::class, 'reward_id');
    }
}
