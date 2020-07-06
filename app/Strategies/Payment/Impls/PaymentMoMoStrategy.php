<?php


namespace App\Strategies\Payment\Impls;


use App\Enum\DepositChannel;
use App\Enum\Status\TransactionStatus;
use App\Models\Transaction;
use App\Service\Traits\CanUseWallet;
use App\Service\Traits\TransactionTrait;
use App\Strategies\Payment\Base\PaymentStrategy;
use App\User;

class PaymentMoMoStrategy implements PaymentStrategy
{
    use CanUseWallet, TransactionTrait;
    /**
     * @inheritDoc
     */
    public function handle($req, User $user)
    {
        $status = $req->success ? TransactionStatus::SUCCESS : TransactionStatus::PENDING;
        $value_original = $req->value_original;
        $value = $value_original/config('payment.exchange_rate');
        /** @var Transaction $transaction */
        $transaction = $this->createTransaction($user, $value, $value_original, DepositChannel::MOMO, null, $status);
        if ($status == TransactionStatus::SUCCESS)
            $this->changeCashOfUser($user, $value, 'Cộng tiền từ giao dịch ' . $transaction->id, 'transactions', $transaction->id);
        return $transaction;
    }
}
