<?php


namespace App\Http\Controllers\Share;


use App\Http\Controllers\Controller;
use App\Service\Contract\RegionService;

class RegionController extends Controller
{
    /**
     * @var RegionService
     */
    private $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    public function provinces() {
        return $this->regionService->provinces();
    }

    public function districtOfProvince($province_id) {
        return $this->regionService->districtOfProvince($province_id);
    }
}
