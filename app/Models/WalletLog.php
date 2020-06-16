<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WalletLog.
 *
 * @package namespace App\Models;
 * @property-read \App\User $user
 * @property-read \App\Models\Wallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $user_id
 * @property int $wallet_id
 * @property int $cash_changed
 * @property int $old_cash
 * @property int $new_cash
 * @property string $reason
 * @property string|null $ref_table
 * @property string|null $ref_index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereCashChanged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereNewCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereOldCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereRefIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereRefTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletLog whereWalletId($value)
 */
class WalletLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet_id',
        'user_id',
        'cash_changed',
        'old_cash',
        'new_cash',
        'reason',
        'ref_table',
        'ref_index'
    ];

    public function wallet() {
        return $this->belongsTo(Wallet::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
