<?php


namespace App\Repositories\Eloquent;


use App\Models\Transaction;
use App\Models\TransactionCashDetail;
use App\Repositories\Common\RepositoryEloquent;
use App\Repositories\Contract\TransactionRepository;

class TransactionRepositoryEloquent extends RepositoryEloquent implements TransactionRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Transaction::class;
    }

    public function findByIdWithRelation($id, $relations = [])
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->with($relations)
            ->firstOrFail();
    }
}
