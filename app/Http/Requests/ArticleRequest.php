<?php


namespace App\Http\Requests;


use App\Enum\Status\CommonStatus;
use App\Http\Requests\Contract\ValidatedRequest;
use App\Http\Requests\Contract\AuthorizedRequest;
use Illuminate\Validation\Rule;

/**
 * Class ArticleRequest
 * @package App\Http\Requests
 *
 * @property-read string $title
 * @property-read string $description
 * @property-read string $author
 * @property-read string $thumbnail
 * @property-read string $content
 * @property-read int $status
 */
class ArticleRequest extends ValidatedRequest
{
    use AuthorizedRequest;

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'thumbnail' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'numeric', Rule::in(CommonStatus::getValues())],
            'content' => ['required', 'string'],
        ];
    }
}
