<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LotteryRewardInfo.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property int $reward_id
 * @property string $name
 * @property string $phone_number
 * @property string $address
 * @property int $province_id
 * @property int $district_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\District $district
 * @property-read \App\Models\Province $province
 * @property-read \App\Models\LotteryReward $reward
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo whereRewardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LotteryRewardInfo whereUpdatedAt($value)
 * @mixin \Eloquent
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
