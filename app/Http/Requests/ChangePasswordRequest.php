<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;


class ChangePasswordRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'string', 'min:6', 'same:password']
        ];
    }
}
