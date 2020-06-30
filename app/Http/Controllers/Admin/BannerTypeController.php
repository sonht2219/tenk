<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\BannerTypeRequest;
use App\Service\Contract\BannerTypeService;
use App\Service\Contract\DtoBuilderService;

class BannerTypeController extends Controller
{
    use AuthorizedController;

    private BannerTypeService $bannerTypeService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(BannerTypeService $bannerTypeService, DtoBuilderService $dtoBuilder)
    {
        $this->bannerTypeService = $bannerTypeService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function create(BannerTypeRequest $request)
    {
        return $this->bannerTypeService->create($request);
    }

    public function list()
    {
        return $this->bannerTypeService->list();
    }

    public function single($id)
    {
        return $this->bannerTypeService->single($id);
    }

    public function edit($id, BannerTypeRequest $request)
    {
        return $this->bannerTypeService->edit($id, $request);
    }

    public function delete($id)
    {
        return $this->bannerTypeService->delete($id);
    }
}
