<?php


namespace App\Strategies\Payment\Impls;


use App\Repositories\Contract\TransactionRepository;
use App\Strategies\Payment\Base\PaymentStrategy;
use App\User;

class PaymentTransferBankStrategy implements PaymentStrategy
{
    private TransactionRepository $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo)
    {

        $this->transactionRepo = $transactionRepo;
    }

    /**
     * @inheritDoc
     */
    public function handle($data, User $user)
    {
    }
}
