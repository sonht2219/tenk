<?php

namespace App\Repositories\Criteria\Feedback;

use App\Repositories\Criteria\Common\WithRelationsCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FeedbackWithAllRelationCriteria.
 *
 * @package namespace App\Repositories\Criteria\Feedback;
 */
class FeedbackWithAllRelationCriteria extends WithRelationsCriteria
{
    public function __construct()
    {
        parent::__construct([
            'lottery', 'product', 'session', 'user'
        ]);
    }
}
