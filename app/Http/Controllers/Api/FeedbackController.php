<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    use AuthorizedController;

    private FeedbackService $feedbackService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(FeedbackService $feedbackService, DtoBuilderService $dtoBuilder)
    {
        $this->feedbackService = $feedbackService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function create(FeedbackRequest $req)
    {
        return $this->dtoBuilder->buildFeedbackDto(
            $this->feedbackService->create($this->user(), $req)
        );
    }

    public function list(Request $req) {
        return $this->baseList($req);
    }

    public function myFeedback(Request $req) {
        return $this->baseList($req, true);
    }

    private function baseList(Request $req, $of_user = false)
    {
        $limit = $req->get('limit') ?: 20;
        $product_id = $req->get('product_id');

        $feedback = $this->feedbackService->list($limit, $product_id, $of_user ? $this->user() : null);

        return [
            'datas' => collect($feedback->items())->map(fn($fb) => $this->dtoBuilder->buildFeedbackDto($fb)),
            'meta' => get_meta($feedback)
        ];
    }
}
