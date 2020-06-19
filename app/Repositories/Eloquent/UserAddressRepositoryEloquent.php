<?php


namespace App\Repositories\Eloquent;


use App\Models\UserAddress;
use App\Repositories\Common\RepositoryEloquent;
use App\Repositories\Contract\UserAddressRepository;

class UserAddressRepositoryEloquent extends RepositoryEloquent implements UserAddressRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return UserAddress::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }


}
