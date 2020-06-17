<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use App\Repositories\Contract\FeedbackRepository;
use App\Models\Feedback;

/**
 * Class FeedbackRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class FeedbackRepositoryEloquent extends RepositoryEloquent implements FeedbackRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Feedback::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
