<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;

/**
 * Class CheckPhoneCardRequest
 * @package App\Http\Requests
 *
 * @property-read $transaction_id
 */

class CheckPhoneCardRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'transaction_id' => ['required', 'string', 'exists:phone_cards,transaction_id']
        ];
    }
}
