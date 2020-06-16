<?php

use App\Enum\Type\UploadFolder;

return [
    'mimes' => ['png', 'jpg', 'jpeg', 'gif'],
    'path' => env('STORAGE_PATH', 'images/upload/'),
    'daily_folder' => [
        UploadFolder::PRODUCTS,
        UploadFolder::USERS,
    ],
];
