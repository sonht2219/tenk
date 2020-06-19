<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;

class UserAddressCreateRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:10'],
            'address' => ['required', 'string', '']
        ];
    }
}
