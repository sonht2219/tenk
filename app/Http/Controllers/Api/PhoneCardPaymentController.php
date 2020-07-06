<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Service\Contract\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PhoneCardPaymentController extends Controller
{

    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function telcos() {
        return config('payment.phone_card.telco');
    }

    public function valuesCard() {
        return config('payment.phone_card.values_card');
    }

    public function callbackCard(Request $req) {
        Log::info('callback controller - ' . json_encode($req->all()));
        $code = $req->get('code');
        $seri = $req->get('seri');
        $telco = $req->get('telco');
        $note = $req->get('note');
        $email = $req->get('email');
        $password = $req->get('pass');
        $card_value = $req->get('cardvalue');
        $true_value = $req->get('truevalue');
        $status = $req->get('status');
        return $this->transactionService->handleCallbackPhoneCard($seri, $code, $telco, $note, $email, $password, $card_value, $true_value, $status);
    }
}
