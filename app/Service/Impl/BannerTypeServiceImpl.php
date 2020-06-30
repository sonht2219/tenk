<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Http\Requests\BannerTypeRequest;
use App\Models\BannerType;
use App\Repositories\Contract\BannerTypeRepository;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Service\Contract\BannerTypeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BannerTypeServiceImpl implements BannerTypeService
{
    private BannerTypeRepository $bannerTypeRepo;

    public function __construct(BannerTypeRepository $bannerTypeRepo)
    {
        $this->bannerTypeRepo = $bannerTypeRepo;
    }

    public function create(BannerTypeRequest $request): BannerType
    {
        return $this->bannerTypeRepo->save(new BannerType($request->filteredData()));
    }

    public function single($id): BannerType
    {
        return $this->bannerTypeRepo->find($id);
    }

    public function list(): Collection
    {
        $this->bannerTypeRepo->pushCriteria(new HasStatusCriteria(CommonStatus::ACTIVE));

        return $this->bannerTypeRepo->all();
    }

    public function edit($id, BannerTypeRequest $request): BannerType
    {
        return $this->bannerTypeRepo->update($request->filteredData(), $id);
    }

    public function delete($id): BannerType
    {
        $type = $this->single($id);
        $type->status = CommonStatus::INACTIVE;
        return $this->bannerTypeRepo->save($type);
    }
}
