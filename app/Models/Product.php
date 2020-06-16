<?php

namespace App\Models;

use App\Enum\Status\CommonStatus;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Product.
 *
 * @package namespace App\Models;
 */
class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'images',
        'thumbnail',
        'price',
        'original_price',
        'status',
        'creator_id'
    ];

    public function creator() {
        return $this->belongsTo(User::class);
    }

}
