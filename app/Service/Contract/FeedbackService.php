<?php

namespace App\Service\Contract;

use App\Exceptions\ExecuteException;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface FeedbackService
{
    /**
     * @param User $user
     * @param FeedbackRequest $req
     * @return Feedback
     * @throws ExecuteException
     */
    public function create(User $user, FeedbackRequest $req): Feedback;

    /**
     * @param $limit
     * @param int|null $product_id
     * @param User|null $user
     * @return LengthAwarePaginator
     */
    public function list($limit, $product_id, $user);

    /**
     * @param $id
     * @return Feedback
     * @throws ModelNotFoundException
     */
    public function single($id);
}
