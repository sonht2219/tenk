<?php


namespace App\Service\Impl;


use App\Http\Requests\DepositCashRequest;
use App\Repositories\Contract\TransactionRepository;
use App\Service\Contract\TransactionService;
use App\Strategies\Payment\Base\PaymentStrategy;
use App\User;

class TransactionServiceImpl implements TransactionService
{
    private TransactionRepository $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
    }

    public function createTransaction($data, $channel = null)
    {

    }

    public function depositCash(DepositCashRequest $req, User $user)
    {
        /** @var PaymentStrategy $payment_strategy */
        $payment_strategy = app()->make(config('payment.' . $req->payment_method));
        return $payment_strategy->handle($req->filteredData(), $user);
    }
}
