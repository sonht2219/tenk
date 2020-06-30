<?php


namespace App\Http\Requests;


use App\Enum\DepositChannel;
use App\Http\Requests\Contract\ValidatedRequest;
use Illuminate\Validation\Rule;

/**
 * Class DepositCashRequest
 * @package App\Http\Requests
 *
 * @property-read $payment_method
 * @property-read $amount
 */
class DepositCashRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'payment_method' => ['required', 'numeric', Rule::in(DepositChannel::getValues())],
            'amount' => ['required', 'numeric', 'min:10000']
        ];
    }
}
