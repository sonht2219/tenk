<?php


namespace HoangDo\Notification\Request;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class NotificationRequest
 * @package HoangDo\Notification\Request
 *
 * @property-read array|string[] $user_ids
 * @property-read int|null $policy_id
 * @property-read string $title
 * @property-read string $description
 * @property-read string $content
 */
class NotificationRequest extends FormRequest
{
    public function rules() {
        /** @var Model $user */
        $user = app(config('notification.user'));
        return [
            'user_ids' => ['array'],
            'user_ids.*' => ['required', 'string', 'exists:' . $user->getTable() . ',id'],
//            'policy_id' => ['nullable','numeric'],
            'title' => ['required', 'string', 'min: 1'],
            'description' => ['required', 'string', 'min:1'],
            'content' => ['required', 'string', 'min:1']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if (request()->expectsJson()) {
            throw new HttpResponseException(restful_exception(new ValidationException($validator)));
        }
        parent::failedValidation($validator);
    }

    public function authorize()
    {
        return true;
    }

    public function filteredData() {
        return filter_data($this->all());
    }
}
