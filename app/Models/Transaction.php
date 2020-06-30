<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transaction
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction query()
 * @mixin \Eloquent
 * @property string $id
 * @property int $value > 0 nếu nạp tiền vào, < 0 nếu dùng tiền mua gói.
 * @property int $old_cash
 * @property int $new_cash
 * @property string $user_id
 * @property string|null $description
 * @property int $status 2: Chờ xử lý. 1: Hoàn thành. -1: Đã hủy.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TransactionCashDetail $cash_detail
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereNewCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereOldCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereValue($value)
 */
class Transaction extends Model
{
    public $incrementing = false;

    protected $fillable = ['id', 'value', 'old_cash', 'new_cash', 'user_id', 'description', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function cash_detail() {
        return $this->hasOne(TransactionCashDetail::class);
    }
}
