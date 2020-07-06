<?php


namespace App\Service\Traits;


use App\Enum\DepositChannel;
use App\Enum\Status\TransactionStatus;
use App\Models\Transaction;
use App\Models\TransactionCashDetail;
use App\Models\Wallet;
use App\Repositories\Contract\TransactionRepository;
use App\Repositories\Contract\WalletRepository;
use App\User;

trait TransactionTrait
{
    use GenerateIdTransactionTrait;
    private bool $is_initialize_transaction_trait = false;
    private TransactionRepository $_transactionRepo;

    protected function createTransaction(User $user, $value, $value_original, $deposit_channel, $id = null, $status = TransactionStatus::PENDING) {
        $this->initializeTransactionTrait();
        /** @var Wallet $wallet */
        $wallet = $user->wallet;
        if ($status == TransactionStatus::SUCCESS) {
            $old_cash = $wallet->cash;
            $new_cash = $wallet->cash + $value;
        } else {
            $old_cash = $new_cash = 0;
        }
        $id = $id ?: $this->generateIdTransaction();
        $user_id = $user->id;
        $description = 'Nạp ' . $value . ' xu qua ' . DepositChannel::getDescription($deposit_channel);
        return $this->saveTransaction(compact('id', 'value', 'old_cash', 'new_cash', 'user_id', 'description', 'status'), $value_original, $deposit_channel);
    }

    private function saveTransaction($data, $value_original, $deposit_channel) {
        $transaction = $this->_transactionRepo->create($data);
        /** @var TransactionCashDetail $transaction_cash_detail */
        $transaction_cash_detail = new TransactionCashDetail();
        $transaction_cash_detail->transaction()->associate($transaction);
        $transaction_cash_detail->value_original = $value_original;
        $transaction_cash_detail->deposit_channel = $deposit_channel;
        $transaction_cash_detail->save();
        return $this->_transactionRepo->findByIdWithRelation($transaction->id, ['cash_detail']);
    }

    private function initializeTransactionTrait() {
        if (!$this->is_initialize_transaction_trait) {
            $this->_transactionRepo = app(TransactionRepository::class);
            $this->is_initialize_transaction_trait = true;
        }
    }
}
