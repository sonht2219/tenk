<?php


namespace App\Strategies\Payment\Impls;


use App\Enum\DepositChannel;
use App\Enum\Status\TransactionStatus;
use App\Exceptions\ExecuteException;
use App\Models\Transaction;
use App\Repositories\Contract\PhoneCardRepository;
use App\Service\Traits\PhoneCardTrait;
use App\Service\Traits\TransactionTrait;
use App\Strategies\Payment\Base\PaymentStrategy;
use App\User;
use Illuminate\Support\Facades\Log;

class PaymentPhoneCardStrategy implements PaymentStrategy
{
    use TransactionTrait, PhoneCardTrait;
    private PhoneCardRepository $phoneCardRepo;

    public function __construct(PhoneCardRepository $phoneCardRepo)
    {
        $this->bootPhoneCardConfig();
        $this->phoneCardRepo = $phoneCardRepo;
    }

    /**
     * @inheritDoc
     */
    public function handle($req, User $user)
    {
        $seri = $req->seri;
        $code = $req->code;
        $telco = $req->telco;
        $value_original = $req->value ?? $req->value_original;
        $value_exchange_cash = $value_original/config('payment.exchange_rate');

        if ($this->phoneCardRepo->existCard($code, $seri))
            throw new ExecuteException(__('Thất bại, thẻ đã tồn tại trong hệ thống.'));

        /** @var Transaction $transaction */
        $transaction = $this->createTransaction($user, $value_exchange_cash, $value_original, DepositChannel::PHONE_CARD, null, DepositChannel::PHONE_CARD);
        $this->saveCard($transaction, $code, $seri, $telco, $value_original, config('payment.phone_card.status.cho_duyet'));
        return $this->payCard($seri, $code, $telco, $value_original, 'nap the');
    }
}
