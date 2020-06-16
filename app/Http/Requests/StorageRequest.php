<?php


namespace App\Http\Requests;


use App\Enum\Type\UploadFolder;
use App\Http\Requests\Contract\ValidatedRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * Class StorageRequest
 * @package App\Http\Requests
 *
 * @property-read UploadedFile $image
 * @property-read string|null $folder
 */
class StorageRequest extends ValidatedRequest
{

    public function rules()
    {
        return [
            'image' => ['required', 'mimes:' . implode(',', config('storage.mimes'))],
            'folder' => ['nullable', 'string', Rule::in(UploadFolder::getValues())]
        ];
    }
}
