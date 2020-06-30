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

    public function createTransaction($data, $deposit_channel = null)
    {
        /** @var Transaction $transaction */
        $transaction = $this->model->newQuery()
            ->create($data);

        if ($deposit_channel) {
            /** @var TransactionCashDetail $transaction_cash_detail */
            $transaction_cash_detail = new TransactionCashDetail();
            $transaction_cash_detail->transaction_id = $transaction->id;
            $transaction_cash_detail->value = $data->value;
            $transaction_cash_detail->deposit_channel = $deposit_channel;
            $transaction_cash_detail->save();
        }
        return $transaction;
    }
}
