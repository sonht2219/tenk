<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;

/**
 * Class RegisterRequest
 * @package App\Http\Requests
 *
 * @property string $email
 * @property string $password
 * @property string|null $avatar
 * @property int|null $birthday
 * @property string|null $name
 */
class RegisterRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        $now = round(microtime(true) * 1000);
        return [
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'phone_number' => ['required', 'numeric', 'max:50', 'unique:users,phone_number'],
            'password' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'string', 'max:255'],
            'birthday' => ['nullable', 'numeric', 'max:'.$now],
        ];
    }
}
