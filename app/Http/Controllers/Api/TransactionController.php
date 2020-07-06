<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepositCashRequest;
use App\Models\Transaction;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $result = $this->transactionService->depositCash($req, $this->user());
        if ($result instanceof Transaction)
            return $this->dtoBuilder->buildTransactionDto($result);
        return ['data' => $result];
    }

    public function bankAccount() {
        return $this->transactionService->bankAccount();
    }
}
