<?php


namespace App\Http\Requests\Contract;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

abstract class ValidatedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public abstract function rules();

    protected function failedValidation(Validator $validator)
    {
        if (request()->expectsJson()) {
            throw new HttpResponseException(restful_exception(new ValidationException($validator)));
        }
        parent::failedValidation($validator);
    }

    public function authorize()
    {
        return true;
    }

    public function filteredData() {
        return filter_data($this->all());
    }
}
