<?php


namespace App\Service\Traits;


use App\Repositories\Contract\TransactionRepository;
use Illuminate\Support\Str;

trait GenerateIdTransactionTrait
{
    private bool $is_initialize_generate_id_transaction = false;
    private TransactionRepository $_transactionRepo;

    protected function generateIdTransaction() {
        $this->initializeGenerateIdTransactionTrait();
        $id = Str::random(6);
        if ($this->_transactionRepo->exists($id))
            return $this->generateIdTransaction();
        return $id;
    }

    private function initializeGenerateIdTransactionTrait() {
        if (!$this->is_initialize_generate_id_transaction) {
            $this->_transactionRepo = app(TransactionRepository::class);
            $this->is_initialize_generate_id_transaction = true;
        }
    }
}
