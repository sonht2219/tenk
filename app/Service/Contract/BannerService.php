<?php


namespace App\Service\Contract;


use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface BannerService
{
    public function create(BannerRequest $request): Banner;
    public function list($limit, $search, $type, $status): LengthAwarePaginator;

    /**
     * @param $id
     * @return Banner
     * @throws ModelNotFoundException
     */
    public function single($id): Banner;

    /**
     * @param $id
     * @param BannerRequest $request
     * @return Banner
     * @throws ModelNotFoundException
     */
    public function edit($id, BannerRequest $request): Banner;

    /**
     * @param $id
     * @return Banner
     * @throws ModelNotFoundException
     */
    public function delete($id): Banner;
}
