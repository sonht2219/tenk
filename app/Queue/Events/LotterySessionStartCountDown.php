<?php


namespace App\Queue\Events;


use App\Models\LotterySession;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LotterySessionStartCountDown implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public LotterySession $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
