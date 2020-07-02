<?php


namespace App\Http\Requests;


use App\Enum\Status\CommonStatus;
use App\Http\Requests\Contract\ValidatedRequest;
use Illuminate\Validation\Rule;

/**
 * Class BotRequest
 * @package App\Http\Requests
 *
 * @property-read string $user_id
 * @property-read int $limit_per_buy
 * @property-read int|null $status
 */
class BotRequest extends ValidatedRequest
{
    public function rules()
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'limit_per_buy' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getValues())],
        ];
    }
}
