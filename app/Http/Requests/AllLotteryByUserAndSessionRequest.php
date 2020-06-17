<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;

class AllLotteryByUserAndSessionRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'session_id' => ['required', 'numeric', 'exists:lottery_sessions,id'],
            'user_id' => ['required', 'string', 'exists:users,id']
        ];
    }
}
