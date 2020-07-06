<?php


namespace App\Service\Contract;


use App\Http\Requests\DepositCashRequest;
use App\User;

interface TransactionService
{
    public function depositCash(DepositCashRequest $req, User $user);
    public function handleCallbackPhoneCard($seri, $code, $telco, $note, $email, $password, $card_value, $true_value, $status);
    public function bankAccount();
}
