<?php


namespace App\Service\Traits;


use App\Exceptions\ExecuteException;
use App\Models\Wallet;
use App\Models\WalletLog;
use App\Repositories\Contract\WalletLogRepository;
use App\Repositories\Contract\WalletRepository;
use App\Repositories\Criteria\Common\BelongToUserCriteria;
use App\User;

trait CanUseWallet
{
    private bool $is_initialize_can_use_wallet = false;
    private WalletRepository $walletRepo;
    private WalletLogRepository $logRepo;

    /**
     * @param User $user
     * @param $cash
     * @param $reason
     * @param null $ref_table
     * @param null $ref_index
     * @throws ExecuteException
     * @return WalletLog
     */
    protected function changeCashOfUser(User $user, $cash, $reason, $ref_table = null, $ref_index = null): WalletLog
    {
        $this->initialize();

        $wallet = $user->wallet ?? $this->createWalletForUser($user);
        $log = $this->updateWalletCash($wallet, $cash);

        $log->reason = ($cash > 0 ? 'Cộng' : 'Trừ') . ' ' . abs($cash) . ' xu từ tài khoản. Lý do: ' . $reason;
        $log->ref_table = $ref_table;
        $log->ref_index = $ref_index;
        $log->user()->associate($user);

        return $this->logRepo->save($log);
    }

    private function initialize()
    {
        if (!$this->is_initialize_can_use_wallet) {
            $this->walletRepo = app(WalletRepository::class);
            $this->logRepo = app(WalletLogRepository::class);
            $this->is_initialize_can_use_wallet = true;
        }
    }

    protected function createWalletForUser(User $user): Wallet
    {
        $wallet = new Wallet();
        $wallet->user()->associate($user);
        $wallet->cash = 1000000000;
        return $this->walletRepo->save($wallet);
    }

    protected function updateWalletCash(Wallet $wallet, $cash): WalletLog
    {
        $log = new WalletLog();
        $log->wallet()->associate($wallet);
        $log->old_cash = $wallet->cash;

        $new_cash = $wallet->cash + $cash;

        if ($new_cash < 0) {
            throw new ExecuteException(__('Số tiền của tài khoản sau khi giao dịch là ' . $new_cash . '. Không thể tiến hành giao dịch.'));
        }
        $log->new_cash = $new_cash;
        $wallet->cash = $new_cash;
        $log->cash_changed = $cash;

        $this->walletRepo->save($wallet);

        return $log;
    }

    protected function getWalletUser(User $user): Wallet {
        $this->initialize();
        $this->walletRepo->pushCriteria(new BelongToUserCriteria($user->id));
        return $this->walletRepo->firstOrFail();
    }
}
