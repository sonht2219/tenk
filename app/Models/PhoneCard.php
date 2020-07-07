<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PhoneCard.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property string $code
 * @property string $seri
 * @property int $telco
 * @property int $value
 * @property int|null $true_value
 * @property int|null $card_value
 * @property string $status
 * @property string $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereCardValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereSeri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereTelco($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereTrueValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereValue($value)
 * @mixin \Eloquent
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhoneCard whereId($value)
 */
class PhoneCard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'seri', 'telco', 'value', 'status', 'true_value', 'card_value', 'transaction_id'];

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }
}
