<?php


namespace HoangDo\Authorization\Model;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Policy
 * @package HoangDo\Authorization\Model
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $status
 * @property boolean $is_admin
 * @property-read Role[]|Collection $roles
 * @property-read User[]|Collection $users
 */
class Policy extends Model
{
    protected $fillable = ['name'];

    protected $casts = [
        'is_admin' => 'boolean'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'policy_role');
    }

    public function users()
    {
        return $this->belongsToMany(config('authorization.user'), 'user_policy');
    }
}
