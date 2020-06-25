<?php


namespace App\Http\Requests;


use App\Http\Requests\Contract\ValidatedRequest;

class UpdateProfileUserRequest extends ValidatedRequest
{

    /**
     * @inheritDoc
     */
    public function rules()
    {
        $now = round(microtime(true) * 1000);
        return [
            'avatar_file' => ['nullable', 'mimes:' . implode(',', config('storage.mimes'))],
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'string'],
            'birthday' => ['nullable', 'numeric', 'max:'.$now]
        ];
    }
}
