<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;

/**
 * Class FeedbackRequest
 * @package App\Http\Requests
 *
 * @property-read int $session_id
 * @property-read string $content
 */
class FeedbackRequest extends ValidatedRequest
{
    public function rules()
    {
        return [
            'session_id' => ['required', 'numeric', 'exists:lottery_sessions,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['required', 'mimes:' . implode(',', config('storage.mimes'))],
            'content' => ['required', 'string']
        ];
    }
}
