<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LotteryRewardInfo.
 *
 * @package namespace App\Models;
 */
class LotteryRewardInfo extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['reward_id', 'name', 'phone_number', 'address', 'province_id', 'district_id', 'status'];

    public function province() {
        return $this->belongsTo(Province::class);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }

    public function reward() {
        return $this->belongsTo(LotteryReward::class, 'reward_id');
    }
}
