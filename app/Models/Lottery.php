<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lottery.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property int $session_id
 * @property int $serial
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status 1: Chưa bán. 2: Đã bán. -1: Không hoạt động.
 * @property-read \App\Models\LotterySession $session
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lottery whereUserId($value)
 * @mixin \Eloquent
 */
class Lottery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_id',
        'serial',
        'status',
        'user_id'
    ];

    public function session() {
        return $this->belongsTo(LotterySession::class, 'session_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
