<?php


namespace App\Service\Impl;


use App\Repositories\Contract\UserRepository;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Service\Contract\UserService;

class UserServiceImpl implements UserService
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function countByStatus($status)
    {
        if (is_numeric($status))
            $this->userRepo->pushCriteria(new HasStatusCriteria($status));

        return $this->userRepo->count();
    }
}
