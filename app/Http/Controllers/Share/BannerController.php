<?php


namespace App\Http\Controllers\Share;


use App\Http\Controllers\Controller;
use App\Service\Contract\BannerService;
use App\Service\Contract\DtoBuilderService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    private BannerService $bannerService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(BannerService $bannerService, DtoBuilderService $dtoBuilder)
    {
        $this->bannerService = $bannerService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function list(Request $req)
    {
        $limit = $req->get('limit') ?: 20;
        $search = $req->get('search');
        $type = $req->get('type');
        $status = $req->get('status');

        $page = $this->bannerService->list($limit, $search, $type, $status);

        return [
            'datas' => collect($page->items())->map(fn($banner) => $this->dtoBuilder->buildBannerDto($banner)),
            'meta' => get_meta($page)
        ];
    }
}
