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
        return $this->querySessionByStatus([LotterySessionStatus::COUNT_DOWNING, LotterySessionStatus::ENDING])
            ->paginate($limit);
    }

    public function listSessionOfUserByStatus($user_id, $statuses, $limit)
    {
        return $this->querySessionByStatus($statuses)
            ->whereHas('lotteries', function (Builder $q) use ($user_id){
                return $q->where('user_id', $user_id);
            })
            ->paginate($limit);
    }

    public function querySessionByStatus($statuses) {
        return $this->model->newQuery()
            ->whereIn('lottery_sessions.status', $statuses)
            ->leftJoin('lottery_rewards', 'lottery_sessions.id', 'lottery_rewards.session_id')
            ->orderBy('lottery_sessions.status')
            ->orderBy('lottery_rewards.created_at', 'desc')
            ->with(['product', 'reward.user', 'reward.lottery'])
            ->select(['lottery_sessions.*']);
    }

    public function userJoinedSession($session_id, $user_id)
    {
        return $this->model->newQuery()
            ->where('id', $session_id)
            ->whereHas('lotteries', function (Builder $q) use ($user_id){
                return $q->where('user_id', $user_id);
            })
            ->exists();
    }
}
