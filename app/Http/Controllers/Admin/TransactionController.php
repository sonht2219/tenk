<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\CheckPhoneCardRequest;
use App\Http\Requests\TransactionEditRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionService $transactionService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(TransactionService $transactionService, DtoBuilderService $dtoBuilder)
    {
        $this->transactionService = $transactionService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function list(Request $req) {
        $search = $req->get('search');
        $status = $req->get('status');
        $limit = $req->get('limit') ?: 10;
        $from = $req->get('from') ? Carbon::createFromTimestampMs($req->get('from')) : null;
        $to = $req->get('to') ? Carbon::createFromTimestampMs($req->get('to')) : null;
        $transactions = $this->transactionService->listTransactions($search, $status, $from, $to, $limit);
        return [
            'datas' => collect($transactions->items())->map(fn($transaction) => $this->dtoBuilder->buildTransactionDto($transaction)),
            'meta' => get_meta($transactions)
        ];
    }
    public function edit($id, TransactionEditRequest $req) {
        return $this->dtoBuilder->buildTransactionDto($this->transactionService->editTransaction($id, $req->status));
    }
    public function checkPhoneCard(CheckPhoneCardRequest $req) {
        return $this->dtoBuilder->buildPhoneCardDto($this->transactionService->checkPhoneCard($req->transaction_id));
    }
}
