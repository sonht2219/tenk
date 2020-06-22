<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;

class ReceiveRewardRequest extends ValidatedRequest
{

    public function rules()
    {
        return [
            'reward_id' => ['required', 'numeric', 'exists:lottery_rewards,id'],
            'user_address_id' => ['required', 'numeric', 'exists:user_addresses,id']
        ];
    }
}
