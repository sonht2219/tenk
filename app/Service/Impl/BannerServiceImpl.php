<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Repositories\Contract\BannerRepository;
use App\Repositories\Criteria\Banner\BannerBelongsToTypeCriteria;
use App\Repositories\Criteria\Banner\BannerSearchCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Service\Contract\BannerService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BannerServiceImpl implements BannerService
{

    private BannerRepository $bannerRepo;

    public function __construct(BannerRepository $bannerRepo)
    {
        $this->bannerRepo = $bannerRepo;
    }

    public function create(BannerRequest $request): Banner
    {
        return $this->bannerRepo->save(new Banner($request->filteredData()));
    }

    public function list($limit, $search, $type, $status): LengthAwarePaginator
    {
        if ($search) {
            $this->bannerRepo->pushCriteria(new BannerSearchCriteria($search));
        }

        if ($type) {
            $this->bannerRepo->pushCriteria(new BannerBelongsToTypeCriteria($type));
        }

        if ($status) {
            $this->bannerRepo->pushCriteria(new HasStatusCriteria($status));
        }

        return $this->bannerRepo->paginate($limit);
    }

    public function single($id): Banner
    {
        return $this->bannerRepo->find($id);
    }

    public function edit($id, BannerRequest $request): Banner
    {
        return $this->bannerRepo->update($request->filteredData(), $id);
    }

    public function delete($id): Banner
    {
        $banner = $this->single($id);
        $banner->status = CommonStatus::INACTIVE;
        return $this->bannerRepo->save($banner);
    }
}
