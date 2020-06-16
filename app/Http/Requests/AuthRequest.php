<?php

namespace App\Http\Requests;

use App\Helper\Constant;
use App\Http\Requests\Contract\ValidatedRequest;

/**
 * Class AuthRequest
 * @package App\Http\Requests
 *
 * @property-read string $phone_number
 * @property-read string $password
 */
class AuthRequest extends ValidatedRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'phone_number' => phone_to_valid($this->phone_number)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->request->set('phone_number', phone_to_valid($this->request->get('phone_number')));
        return [
            'phone_number' => ['required', 'string', 'regex:'.Constant::PHONE_REGEXP],
            'password' => ['required', 'string', 'max:50']
        ];
    }
}
