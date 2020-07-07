<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\PhoneCardRepository;
use App\Models\PhoneCard;

/**
 * Class PhoneCardRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class PhoneCardRepositoryEloquent extends RepositoryEloquent implements PhoneCardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PhoneCard::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findByIdAndWithRelations($id, $relations = [])
    {
        return $this->model->newQuery()
            ->where(compact('id'))
            ->with($relations)
            ->firstOrFail();
    }

    public function existCard($code, $seri): bool
    {
        return $this->model->newQuery()
            ->where(compact('code'))
            ->where(compact('seri'))
            ->exists();
    }

    public function findByCodeAndSeri($code, $seri)
    {
        return $this->model->newQuery()
            ->where(compact('code'))
            ->where(compact('seri'))
            ->firstOrFail();
    }

    public function findByTransaction($transaction_id, $relations = [])
    {
        return $this->model->newQuery()
            ->where(compact('transaction_id'))
            ->with($relations)
            ->firstOrFail();
    }
}
