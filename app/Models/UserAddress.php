<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserAddress
 *
 * @property int $id
 * @property string $name
 * @property string $phone_number
 * @property string $address
 * @property int $province_id
 * @property int $district_id
 * @property int $type 1: Default. 0: Normal.
 * @property int $status 1: Hoạt động. -1: Không hoạt động.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $user_id
 * @property-read \App\Models\District $district
 * @property-read \App\Models\Province $province
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress whereUserId($value)
 */
class UserAddress extends Model
{
    protected $fillable = ['user_id', 'name', 'phone_number', 'address', 'province_id', 'district_id', 'type', 'status'];

    public function province() {
        return $this->belongsTo(Province::class);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }
}
