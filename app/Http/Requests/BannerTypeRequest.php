<?php


namespace App\Http\Requests;


use App\Enum\Status\CommonStatus;
use App\Http\Requests\Contract\ValidatedRequest;
use App\Http\Requests\Contracts\AuthorizedRequest;
use Illuminate\Validation\Rule;

/**
 * Class BannerTypeRequest
 * @package App\Http\Requests
 *
 * @property-read string $name
 * @property-read int $status
 */
class BannerTypeRequest extends ValidatedRequest
{

    use AuthorizedRequest;

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getValues())]
        ];
    }
}
