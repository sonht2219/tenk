<?php


namespace App\Service\Traits;


use App\Exceptions\ExecuteException;
use App\Models\Wallet;
use App\Models\WalletLog;
use App\Repositories\Contract\WalletLogRepository;
use App\Repositories\Contract\WalletRepository;
use App\User;

trait CanUseWallet
{
    private bool $is_initialize = false;
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

        return $this->logRepo->save($log);
    }

    protected function initialize()
    {
        if (!$this->is_initialize) {
            $this->walletRepo = app(WalletLogRepository::class);
            $this->logRepo = app(WalletLogRepository::class);
            $this->is_initialize = true;
        }
    }

    protected function createWalletForUser(User $user): Wallet
    {
        $wallet = new Wallet();
        $wallet->user()->associate($user);
        return $this->walletRepo->save($wallet);
    }

    protected function updateWalletCash(Wallet $wallet, $cash): WalletLog
    {
        $log = new WalletLog();
        $log->old_cash = $wallet->cash;

        $new_cash = $wallet->cash + $cash;

        if ($new_cash < 0) {
            throw new ExecuteException(__('Số tiền của tài khoản sau khi giao dịch là ' . $new_cash . '. Không thể tiến hành giao dịch.'));
        }
        $log->new_cash = $new_cash;
        $wallet->cash = $new_cash;

        $this->walletRepo->save($wallet);

        return $log;
    }
}
