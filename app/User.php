<?php

namespace App;

use App\Models\Wallet;
use App\Notifications\CustomVerifyEmailQueued;
use HoangDo\Authorization\Model\Policy;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $phone_number
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $avatar
 * @property string|null $social_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status 1: Hoạt động. -1: Không hoạt động.
 * @property-read Policy[]|Collection $policies
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSocialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @property-read \App\Models\Wallet|null $wallet
 * @property \Illuminate\Support\Carbon|null $birthday
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBirthday($value)
 */
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'phone_number', 'password', 'email', 'avatar', 'social_id', 'status', 'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'datetime'
    ];

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        $result = [
            'is_admin' => false,
            'roles' => []
        ];
        foreach ($this->policies as $policy) {
            if ($policy->is_admin) $result['is_admin'] = true;
            foreach ($policy->roles as $role)
                $result['roles'][] = $role->id;
        }
        return $result;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmailQueued);
    }

    public function wallet() {
        return $this->hasOne(Wallet::class);
    }

    public function policies()
    {
        return $this->belongsToMany(Policy::class, 'user_policy');
    }
}
