<?php


namespace App\Service\Contract;


use App\Http\Requests\DepositCashRequest;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TransactionService
{
    public function depositCash(DepositCashRequest $req, User $user);
    public function handleCallbackPhoneCard($seri, $code, $telco, $note, $email, $password, $card_value, $true_value, $status);
    public function bankAccount();
    public function listTransactions($search, $status, $from, $to, $limit): LengthAwarePaginator;
    public function singleTransaction($id);
    public function editTransaction($id, $status);
    public function checkPhoneCard($transaction_id);
}
