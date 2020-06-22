<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;

class UserAddressEditRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string'],
            'province_id' => ['nullable', 'numeric', 'exists:provinces,id'],
            'district_id' => ['nullable', 'numeric', 'exists:districts,id'],
            'default' => ['nullable', 'numeric']
        ];
    }
}
