<?php


namespace App\Http\Requests;


use App\Helper\Constant;
use App\Http\Requests\Contract\ValidatedRequest;
use App\Repositories\Contract\UserRepository;

/**
 * Class RegisterRequest
 * @package App\Http\Requests
 *
 * @property string $phone_number
 * @property string $password
 * @property string|null $avatar
 * @property int|null $birthday
 * @property string|null $name
 */
class RegisterRequest extends ValidatedRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
           'phone_number' => phone_to_valid($this->phone_number)
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'unique:users,phone_number', 'regex:'.Constant::PHONE_REGEXP],
            'password' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
