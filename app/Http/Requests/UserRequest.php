<?php


namespace App\Http\Requests;


use App\Helper\Constant;
use App\Http\Requests\Contract\ValidatedRequest;

/**
 * Class UserRequest
 * @package App\Http\Requests
 * @property-read $name
 * @property-read $phone_number
 * @property-read $email
 * @property-read $password
 * @property-read $avatar
 * @property-read $birthday
 */
class UserRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        $method = request()->method();
        $rules = [
            'name' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'regex:'.Constant::PHONE_REGEXP, 'unique:users,phone_number'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'max:50'],
            'avatar' => ['required', 'string'],
            'birthday' => ['required', 'numeric']
        ];
        if ($method == 'PUT')
            $rules = [
                'name' => ['nullable', 'string'],
                'password' => ['nullable', 'string', 'max:50'],
                'avatar' => ['nullable', 'string'],
                'birthday' => ['nullable', 'numeric']
            ];

        return $rules;
    }
}
