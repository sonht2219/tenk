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
 * @property-read $value_original
 * @property-read $seri
 * @property-read $code
 * @property-read $telco
 * @property-read $value
 * @property-read $success
 */
class DepositCashRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        $telcos = collect(config('payment.phone_card.telco'))->pluck('value');
        $valuesCard = collect(config('payment.phone_card.values_card'))->pluck('value');
        return [
            'payment_method' => ['required', 'numeric', Rule::in(DepositChannel::getValues())],
            'value_original' => ['required', 'numeric', 'min:10000'],
            'seri' => ['required_if:payment_method,'. DepositChannel::PHONE_CARD, 'string'],
            'code' => ['required_if:payment_method,'. DepositChannel::PHONE_CARD, 'string'],
            'telco' => ['required_if:payment_method,'. DepositChannel::PHONE_CARD, 'numeric', Rule::in($telcos)],
            'value' => ['required_if:payment_method,'. DepositChannel::PHONE_CARD, 'numeric', Rule::in($valuesCard)],

            'success' => ['nullable', 'numeric'],
        ];
    }
}
