<?php


namespace App\Repositories\Criteria\Transaction;


use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class TransactionSearchCriteria implements CriteriaInterface
{
    private $search;

    public function __construct($search)
    {
        $this->search = $search;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function (Builder $q) {
            $search = '%' . $this->search . '%';
            return $q->where('id', 'like', $search)
                ->orWhereHas('user', function (Builder $q) use ($search) {
                    return $q->where('name', 'like', $search)
                        ->orWhere('phone_number', 'like', $search)
                        ->orWhere('email', 'like', $search);
                })
                ->orWhereHas('phone_card', function (Builder $q) use ($search) {
                    return $q->where('seri', 'like', $search)
                        ->orWhere('code', 'like', $search);
                });
        });
    }
}
