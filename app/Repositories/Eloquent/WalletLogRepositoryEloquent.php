<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\WalletLogRepository;
use App\Models\WalletLog;

/**
 * Class WalletLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class WalletLogRepositoryEloquent extends RepositoryEloquent implements WalletLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WalletLog::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
