<?php


namespace App\Service\Impl;


use App\Http\Requests\DepositCashRequest;
use App\Repositories\Contract\TransactionRepository;
use App\Service\Contract\TransactionService;
use App\Service\Traits\PhoneCardTrait;
use App\Strategies\Payment\Base\PaymentStrategy;
use App\User;

class TransactionServiceImpl implements TransactionService
{
    use PhoneCardTrait;
    private TransactionRepository $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
        $this->bootPhoneCardConfig();
    }

    public function depositCash(DepositCashRequest $req, User $user)
    {
        /** @var PaymentStrategy $payment_strategy */
        $payment_strategy = app()->make(config('payment.method.' . $req->payment_method));
        return $payment_strategy->handle($req, $user);
    }

    public function handleCallbackPhoneCard($seri, $code, $telco, $note, $email, $password, $card_value, $true_value, $status)
    {
        return $this->callbackCard($seri, $code, $telco, $note, $email, $password, $card_value, $true_value, $status);
    }

    public function bankAccount()
    {
        return [
            'bank_id' => '1903678999999',
            'owner_name' => 'Công ty TNHH Tenk Việt Nam',
            'bank_name' => 'Ngân hàng Techcombank',
            'bank_branch' => 'Trụ sở'
        ];
    }
}
