<?php


namespace App\Queue\Events;


use App\Models\PhoneCard;
use App\Models\Transaction;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepositCashPhoneCardCallbacked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PhoneCard $phone_card;
    public User $user;

    public function __construct(PhoneCard $phone_card, User $user)
    {
        $this->phone_card = $phone_card;
        $this->user = $user;
    }

    /**
     * @inheritDoc
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
