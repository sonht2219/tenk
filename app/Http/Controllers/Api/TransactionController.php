<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepositCashRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\TransactionService;

class TransactionController extends Controller
{
    use AuthorizedController;
    private TransactionService $transactionService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(TransactionService $transactionService, DtoBuilderService $dtoBuilder)
    {
        $this->transactionService = $transactionService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function depositCash(DepositCashRequest $req) {
        $transaction = $this->transactionService->depositCash($req, $this->user());
        return $this->dtoBuilder->buildTransactionDto($transaction);
    }

    public function bankAccount() {
        return $this->transactionService->bankAccount();
    }
}
