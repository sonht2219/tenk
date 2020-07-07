<?php


namespace App\Service\Traits;


use App\Enum\Status\TransactionStatus;
use App\Exceptions\ExecuteException;
use App\Models\PhoneCard;
use App\Models\Transaction;
use App\Models\TransactionCashDetail;
use App\Models\Wallet;
use App\Queue\Events\DepositCashPhoneCardCallbacked;
use App\Repositories\Contract\PhoneCardRepository;
use App\Repositories\Contract\WalletRepository;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Collection;

trait PhoneCardTrait
{
    use CanUseWallet;
    private string $_email;
    private string $_password;
    private string $_api_url;
    private Client $_http_client;
    private PhoneCardRepository $_phoneCardRepo;

    public function bootPhoneCardConfig()
    {
        $this->_http_client = new Client();
        $this->_email = config('payment.phone_card.email');
        $this->_password = config('payment.phone_card.password');
        $this->_api_url = config('payment.phone_card.api_url');
        $this->_phoneCardRepo = app(PhoneCardRepository::class);
    }

    protected function payCard($seri, $code, $telco, $value, $note = '') {
        $data = compact('seri', 'code', 'telco', 'value', 'note') + ['email' => $this->_email];
        $url = $this->_api_url . '?' . http_build_query($data);
        return $this->_http_client->get($url)->getBody()->getContents();
    }

    protected function checkCard($seri, $code, $telco, $note = '') {
        $isjson = true;
        $data = compact('seri', 'code', 'telco', 'note', 'isjson') + ['email' => $this->_email];
        $url = $this->_api_url . '?' .http_build_query($data);
        return json_decode($this->_http_client->get($url)->getBody(), true);
    }

    protected function callbackCard($seri, $code, $telco, $note, $email, $password, $card_value, $true_value, $status) {
        Log::info('callback service - ' . json_encode(compact('seri', 'code', 'telco', 'note', 'email', 'password', 'card_value', 'true_value', 'status')));
        Log::info('password md5 - ' . md5($this->_password));
        if ($email != $this->_email || $password != md5($this->_password))
            throw new ExecuteException(__('Phản hồi không hợp lệ'));
        if (!$seri || !$code || !$telco)
            throw new ExecuteException(__('Phản hồi thiếu thông tin'));

        /** @var PhoneCard $phone_card */
        $phone_card = $this->_phoneCardRepo->findByCodeAndSeri($code, $seri);
        $phone_card = $this->_phoneCardRepo->update(compact('true_value', 'card_value', 'status'), $phone_card->id);

        /** @var Transaction $transaction */
        $transaction = $phone_card->transaction;
        /** @var User $user */
        $user = $transaction->user;

        if ($card_value > 0) {
            /** @var Wallet $wallet */
            $wallet = $user->wallet;
            $cash_exchange = $card_value/config('payment.exchange_rate');
            $transaction->value = $cash_exchange;
            $transaction->old_cash = $wallet->cash;
            $transaction->new_cash = $wallet->cash + $cash_exchange;
            $transaction->status = TransactionStatus::SUCCESS;
            $transaction->save();

            /** @var TransactionCashDetail $transaction_detail_cash */
            $transaction_detail_cash = $transaction->cash_detail;
            $transaction_detail_cash->value_original = $true_value;
            $transaction_detail_cash->save();

            $this->changeCashOfUser($user, $cash_exchange, 'Cộng tiền từ giao dịch ' . $transaction->id, 'transactions', $transaction->id);
        } else {
            $transaction->status = TransactionStatus::REJECT;
            $transaction->save();
        }

        event(new DepositCashPhoneCardCallbacked($phone_card, $user));
        return true;
    }

    protected function saveCard(Transaction $transaction, $code, $seri, $telco, $value, $status, $true_value = null, $card_value = null) {
        $phone_card = new PhoneCard(compact('code', 'seri', 'telco', 'value', 'status', 'true_value', 'card_value'));
        $phone_card->transaction()->associate($transaction);
        return $this->_phoneCardRepo->save($phone_card);
    }
}
