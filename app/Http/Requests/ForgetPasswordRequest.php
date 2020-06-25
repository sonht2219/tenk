<?php


namespace App\Http\Requests;

use App\Http\Requests\Contract\ValidatedRequest;

class ForgetPasswordRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email']
        ];
    }
}
