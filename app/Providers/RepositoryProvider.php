<?php


namespace App\Providers;


use App\Repositories\Contract\UserRepository;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider  extends ServiceProvider
{
    public array $singletons = [
        UserRepository::class => UserRepositoryEloquent::class
    ];
}
