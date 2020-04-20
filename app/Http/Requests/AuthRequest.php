<?php

namespace App\Http\Requests;

use App\Http\Requests\Contract\ValidatedRequest;

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
            'email' => ['required', 'email', 'max:191'],
            'password' => ['required', 'string', 'max:50']
        ];
    }
}
