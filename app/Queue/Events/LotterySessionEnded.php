<?php


namespace App\Queue\Events;


use App\Models\LotteryReward;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LotterySessionEnded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public LotteryReward $reward;

    public function __construct(LotteryReward $reward)
    {
        $this->reward = $reward;
    }

    /**
     * @inheritDoc
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
