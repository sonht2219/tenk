<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lottery.
 *
 * @package namespace App\Models;
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
