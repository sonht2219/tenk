<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BotRequest;
use App\Service\Contract\BotService;
use App\Service\Contract\DtoBuilderService;
use Illuminate\Http\Request;

class BotController extends Controller
{
    use AuthorizedController;

    private BotService $botService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(BotService $botService, DtoBuilderService $dtoBuilder)
    {
        $this->botService = $botService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function create(BotRequest $req)
    {
        return $this->dtoBuilder->buildBotDto(
            $this->botService->create($req)
        );
    }

    public function list(Request $req)
    {
        $limit = $req->get('limit') ?: 20;
        $search = $req->get('search');

        $page = $this->botService->list($limit, $search);

        return [
            'datas' => collect($page->items())->map(fn($bot) => $this->dtoBuilder->buildBotDto($bot)),
            'meta' => get_meta($page)
        ];
    }

    public function single($id)
    {
        return $this->dtoBuilder->buildBotDto(
            $this->botService->single($id)
        );
    }

    public function edit($id, BotRequest $req)
    {
        return $this->dtoBuilder->buildBotDto(
            $this->botService->edit($id, $req)
        );
    }

    public function delete($id)
    {
        return $this->dtoBuilder->buildBotDto(
            $this->botService->delete($id)
        );
    }
}
