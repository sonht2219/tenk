<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BannerType.
 *
 * @package namespace App\Models;
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BannerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BannerType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BannerType query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $status 1: Hoạt động. -1: Không hoạt động.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BannerType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BannerType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BannerType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BannerType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BannerType whereUpdatedAt($value)
 */
class BannerType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'status'];

}
