<?php


namespace App\Http\Requests;


use App\Enum\Status\TransactionStatus;
use App\Http\Requests\Contract\ValidatedRequest;
use Illuminate\Validation\Rule;

/**
 * Class TransactionEditRequest
 * @package App\Http\Requests
 *
 * @property-read $status
 */
class TransactionEditRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'status' => ['required', 'numeric', Rule::in(TransactionStatus::getValues())]
        ];
    }
}
