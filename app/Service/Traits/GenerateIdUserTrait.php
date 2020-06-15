<?php


namespace App\Services\Traits;


use App\Repositories\Contract\UserRepository;
use Illuminate\Support\Str;

trait GenerateIdUserTrait
{
    private UserRepository $_userRepo;

    protected function setUserRepositoryForGenerateId(UserRepository $userRepo) {
        $this->_userRepo = $userRepo;
    }

    private function generateId() {
        $id = Str::random(6);
        if ($this->_userRepo->exists($id))
            return $this->generateId();
        return $id;
    }
}
