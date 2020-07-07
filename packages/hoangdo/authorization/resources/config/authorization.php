<?php

return [
    'user' => 'App\User',
    'roles_enum' => env('AUTHORIZATION_ROLES', 'App\Enum\Type\Role')
];
