<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Service\Contract\BannerService;
use App\Service\Contract\DtoBuilderService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use AuthorizedController;

    private BannerService $bannerService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(BannerService $bannerService, DtoBuilderService $dtoBuilder)
    {
        $this->bannerService = $bannerService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function create(BannerRequest $request)
    {
        return $this->dtoBuilder->buildBannerDto(
            $this->bannerService->create($request)
        );
    }

    public function single($id)
    {
        return $this->dtoBuilder->buildBannerDto(
            $this->bannerService->single($id)
        );
    }

    public function edit($id, BannerRequest $request)
    {
        return $this->dtoBuilder->buildBannerDto(
            $this->bannerService->edit($id, $request)
        );
    }

    public function delete($id)
    {
        return $this->dtoBuilder->buildBannerDto(
            $this->bannerService->delete($id)
        );
    }

}
