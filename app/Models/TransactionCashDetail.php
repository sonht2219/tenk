<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TransactionCashDetail
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCashDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCashDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCashDetail query()
 * @mixin \Eloquent
 * @property string $transaction_id
 * @property int $value_original
 * @property int $deposit_channel 1: MOMO. 2: Thẻ cào. 3: Chuyển khoản.
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCashDetail whereDepositChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCashDetail whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TransactionCashDetail whereValueOriginal($value)
 */
class TransactionCashDetail extends Model
{
    protected $fillable = ['transaction_id', 'value_original', 'deposit_channel'];
    public $timestamps = false;

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }
}
