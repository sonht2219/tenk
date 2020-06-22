<?php


namespace App\Http\Requests;


use App\Enum\Type\UserAddressType;
use App\Http\Requests\Contract\ValidatedRequest;
use Illuminate\Validation\Rule;

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
            'address' => ['required', 'string'],
            'province_id' => ['required', 'numeric', 'exists:provinces,id'],
            'district_id' => ['required', 'numeric', 'exists:districts,id'],
            'type' => ['nullable', 'numeric', Rule::in(UserAddressType::getValues())]
        ];
    }
}
