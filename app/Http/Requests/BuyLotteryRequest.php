<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;

class BuyLotteryRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'session_id' => ['required', 'numeric', 'exists:lottery_sessions,id'],
            'lottery_ids' => ['required', 'array'],
            'lottery_ids.*' => ['required', 'numeric', 'exists:lotteries:id']
        ];
    }
}
