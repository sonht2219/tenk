<?php

namespace App\Http\Requests;

use App\Http\Requests\Contract\ValidatedRequest;

/**
 * Class AuthRequest
 * @package App\Http\Requests
 *
 * @property-read string $email
 * @property-read string $password
 */
class AuthRequest extends ValidatedRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => ['required', 'email', 'max:191'],
            'password' => ['required', 'string', 'max:50']
        ];
    }
}
