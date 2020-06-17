<?php


namespace App\Service\Impl;


use App\Enum\Status\LotterySessionStatus;
use App\Enum\Type\UploadFolder;
use App\Exceptions\ExecuteException;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Models\LotterySession;
use App\Queue\Events\FeedbackCreated;
use App\Repositories\Contract\FeedbackRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Criteria\Common\BelongToUserCriteria;
use App\Repositories\Criteria\Feedback\FeedBackOfProductCriteria;
use App\Repositories\Criteria\Feedback\FeedbackWithAllRelationCriteria;
use App\Service\Contract\FeedbackService;
use App\Service\Contract\FileService;
use App\User;

class FeedBackServiceImpl implements FeedbackService
{
    private LotterySessionRepository $sessionRepo;
    private FeedbackRepository $feedbackRepos;
    private FileService $fileService;

    public function __construct(LotterySessionRepository $sessionRepo, FeedbackRepository $feedbackRepos, FileService $fileService)
    {
        $this->sessionRepo = $sessionRepo;
        $this->feedbackRepos = $feedbackRepos;
        $this->fileService = $fileService;
    }

    public function create(User $user, FeedbackRequest $req): Feedback
    {
        /** @var LotterySession $session */
        $session = $this->sessionRepo->find($req->session_id);

        if ($session->status != LotterySessionStatus::ENDING) {
            throw new ExecuteException(__('Không thể đánh giá cho phiên chưa kết thúc'));
        }

        $reward = $session->reward;
        if (!$reward || $reward->user_id != $user->id) {
            throw new ExecuteException(__('Bạn không có quyền đánh giá phiên này'));
        }

        $feedback = new Feedback();
        $feedback->user()->associate($user);

        $feedback->session()->associate($session);
        $feedback->product()->associate($session->product);
        $feedback->lottery()->associate($reward->lottery);
        $feedback->content = $req->content;

        $images = collect($req->file('images'))
            ->map(fn($img) => $this->fileService->storeFile($img, UploadFolder::USERS))
            ->toArray();

        $feedback->images = implode(',', $images);

        $feedback = $this->feedbackRepos->save($feedback);

        event(new FeedbackCreated($feedback));

        return $feedback;
    }

    public function list($limit, $product_id, $user)
    {
        if ($product_id) {
            $this->feedbackRepos->pushCriteria(new FeedBackOfProductCriteria($product_id));
        }

        if ($user) {
            $this->feedbackRepos->pushCriteria(new BelongToUserCriteria($user->id));
        }

        $this->feedbackRepos->pushCriteria(FeedbackWithAllRelationCriteria::class);

        return $this->feedbackRepos->paginate($limit);
    }

    public function single($id)
    {
        $this->feedbackRepos->pushCriteria(FeedbackWithAllRelationCriteria::class);
        return $this->feedbackRepos->find($id);
    }
}
