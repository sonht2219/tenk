<?php

namespace App\Repositories\Eloquent;

use App\Enum\Status\LotterySessionStatus;
use App\Repositories\Common\RepositoryEloquent;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\LotterySessionRepository;
use App\Models\LotterySession;

/**
 * Class LotterySessionRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class LotterySessionRepositoryEloquent extends RepositoryEloquent implements LotterySessionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LotterySession::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findByIdWithRelations($id, $relations)
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->with($relations)
            ->first();
    }

    public function listSessionOpeningAndEnded($limit)
    {
        return $this->model->newQuery()
            ->leftJoin('lottery_rewards', 'lottery_sessions.id', 'lottery_rewards.session_id')
            ->where(function (Builder $q) {
                $q->where('lottery_sessions.status', LotterySessionStatus::COUNT_DOWNING)
                    ->orWhere('lottery_sessions.status', LotterySessionStatus::ENDING);
            })
            ->orderBy('lottery_sessions.status')
            ->orderBy('lottery_rewards.created_at', 'desc')
            ->with(['product', 'reward.user', 'reward.lottery'])
            ->select(['lottery_sessions.*'])
            ->paginate($limit);
    }

}
