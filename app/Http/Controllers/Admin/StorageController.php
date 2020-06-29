<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\StorageRequest;
use App\Service\Contract\FileService;

class StorageController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function saveImage(StorageRequest $storageRequest) {
        $file = $storageRequest->file('image');
        $folder = $storageRequest->folder;

        $path = $this->fileService->storeFile($file, $folder);

        return [
            'path' => $path,
            'url' => $this->fileService->uploaded_url($path),
            'full_path' => $this->fileService->full_path($path),
        ];
    }
}
