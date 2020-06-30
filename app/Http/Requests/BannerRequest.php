<?php


namespace App\Http\Requests;


use App\Enum\Status\CommonStatus;
use App\Http\Requests\Contract\ValidatedRequest;
use Illuminate\Validation\Rule;

/**
 * Class BannerRequest
 * @package App\Http\Requests
 *
 * @property-read string $title
 * @property-read string $navigate_to
 * @property-read string $image
 * @property-read int $ordinal_number
 * @property-read int $banner_type_id
 * @property-read int}null $status
 */
class BannerRequest extends ValidatedRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'navigate_to' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'ordinal_number' => ['required', 'numeric', 'min:0'],
            'banner_type_id' => ['required', 'numeric', 'exists:banner_types,id'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getInstances())]
        ];
    }
}
