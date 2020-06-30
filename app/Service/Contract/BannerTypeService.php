<?php


namespace App\Service\Contract;


use App\Http\Requests\BannerTypeRequest;
use App\Models\BannerType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface BannerTypeService
{
    public function create(BannerTypeRequest $request): BannerType;

    /**
     * @param $id
     * @return BannerType
     * @throws ModelNotFoundException
     */
    public function single($id): BannerType;
    public function list(): Collection;

    /**
     * @param $id
     * @param BannerTypeRequest $request
     * @return BannerType
     * @throws ModelNotFoundException
     */
    public function edit($id, BannerTypeRequest $request): BannerType;

    /**
     * @param $id
     * @return BannerType
     * @throws ModelNotFoundException
     */
    public function delete($id): BannerType;
}
