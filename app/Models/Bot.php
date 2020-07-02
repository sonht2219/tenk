<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bot.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property string $user_id
 * @property int $limit_per_buy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status 1: Hoạt động. -1: Không hoạt động.
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereLimitPerBuy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bot whereUserId($value)
 * @mixin \Eloquent
 */
class Bot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'limit_per_buy',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
