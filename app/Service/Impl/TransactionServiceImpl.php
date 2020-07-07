<?php


namespace App\Service\Impl;


use App\Enum\Status\TransactionStatus;
use App\Exceptions\ExecuteException;
use App\Http\Requests\DepositCashRequest;
use App\Models\PhoneCard;
use App\Models\Transaction;
use App\Models\TransactionCashDetail;
use App\Models\Wallet;
use App\Repositories\Contract\PhoneCardRepository;
use App\Repositories\Contract\TransactionRepository;
use App\Repositories\Criteria\Common\HasFromCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\Common\HasToCriteria;
use App\Repositories\Criteria\Common\OrderByCreatedAtDescCriteria;
use App\Repositories\Criteria\Common\WithRelationsCriteria;
use App\Repositories\Criteria\Transaction\TransactionSearchCriteria;
use App\Service\Contract\TransactionService;
use App\Service\Traits\PhoneCardTrait;
use App\Strategies\Payment\Base\PaymentStrategy;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionServiceImpl implements TransactionService
{
    use PhoneCardTrait;
    private TransactionRepository $transactionRepo;
    private PhoneCardRepository $phoneCardRepo;

    public function __construct(TransactionRepository $transactionRepo, PhoneCardRepository $phoneCardRepo)
    {
        $this->transactionRepo = $transactionRepo;
        $this->bootPhoneCardConfig();
        $this->phoneCardRepo = $phoneCardRepo;
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

    public function listTransactions($search, $status, $from, $to, $limit): LengthAwarePaginator
    {
        if ($from)
            $this->transactionRepo->pushCriteria(new HasFromCriteria($from));
        if ($to)
            $this->transactionRepo->pushCriteria(new HasToCriteria($to));
        if ($status)
            $this->transactionRepo->pushCriteria(new HasStatusCriteria($status));
        if ($search)
            $this->transactionRepo->pushCriteria(new TransactionSearchCriteria($search));

        $this->transactionRepo->pushCriteria(OrderByCreatedAtDescCriteria::class);
        $this->transactionRepo->pushCriteria(new WithRelationsCriteria(['cash_detail', 'user']));
        return $this->transactionRepo->paginate($limit);
    }

    public function singleTransaction($id)
    {
        return $this->transactionRepo->findByIdWithRelation($id, ['user', 'cash_detail']);
    }

    public function editTransaction($id, $status)
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionRepo->find($id);
        /** @var User $user */
        $user = $transaction->user;
        /** @var Wallet $wallet */
        $wallet = $user->wallet;

        if ($transaction->status != TransactionStatus::PENDING)
            throw new ExecuteException(__('Giao dịch đã hoàn thành hoặc đã hủy'));

        $transaction->status = $status;
        if ($status == TransactionStatus::SUCCESS) {
            $transaction->old_cash = $wallet->cash;
            $transaction->new_cash = $wallet->cash + $transaction->value;
        }
        $this->transactionRepo->save($transaction);
        if ($status == TransactionStatus::SUCCESS)
            $this->changeCashOfUser($user, $transaction->value, 'Cộng tiền từ giao dịch ' . $transaction->id, 'transactions', $transaction->id);

        return $transaction;
    }

    public function checkPhoneCard($transaction_id)
    {
        /** @var PhoneCard $phone_card */
        $phone_card = $this->phoneCardRepo->findByTransaction($transaction_id, ['transaction', 'transaction.user', 'transaction.cash_detail']);
        $result = $this->checkCard($phone_card->seri, $phone_card->code, $phone_card->telco);
        if (!$result)
            throw new ExecuteException(__('Email lỗi hoặc thẻ cào không tồn tại'));

        if (!isset($result['status']) || !isset($result['trueval']) || !isset($result['fakeval']))
            throw new ExecuteException(__('Không kiểm tra được thẻ'));

        $phone_card->status = $result['status'];
        $phone_card->card_value = $result['fakeval'];
        $phone_card->true_value = $result['trueval'];
        $phone_card->save();

        /** @var Transaction $transaction */
        $transaction = $phone_card->transaction;
        /** @var TransactionCashDetail $transaction_cash_detail */
        $transaction_cash_detail = $transaction->cash_detail;
        if($transaction->status == TransactionStatus::PENDING && $phone_card->card_value > 0 && $phone_card->true_value > 0) {
            $cash_exchange_true = $phone_card->card_value/config('payment.exchange_rate');
            if ($transaction->value != $cash_exchange_true) {
                $transaction->value = $cash_exchange_true;
                $transaction->save();
            }
            if ($transaction_cash_detail->value_original != $phone_card->true_value) {
                $transaction_cash_detail->value_original = $phone_card->true_value;
                $transaction_cash_detail->save();
            }
        }

        return $phone_card;
    }
}
