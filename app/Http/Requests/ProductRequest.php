<?php


namespace App\Http\Requests;


use App\Enum\Status\CommonStatus;
use App\Http\Requests\Contract\ValidatedRequest;
use Illuminate\Validation\Rule;

/**
 * Class ProductRequest
 * @package App\Http\Requests
 *
 * @property-read string $name
 * @property-read string $description
 * @property-read array $images
 * @property-read int $price
 * @property-read int $original_price
 * @property-read int|null $status
 * @property-read bool|null $will_start_session
 */
class ProductRequest extends ValidatedRequest
{

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'original_price' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getValues())],
            'will_start_session' => ['nullable', 'boolean']
        ];
    }
}
