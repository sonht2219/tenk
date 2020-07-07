<?php


namespace App\Service\Impl;


use App\Repositories\Contract\DistrictRepository;
use App\Repositories\Contract\ProvinceRepository;
use App\Service\Contract\RegionService;

class RegionServiceImpl implements RegionService
{
    /**
     * @var ProvinceRepository
     */
    private $provinceRepo;
    /**
     * @var DistrictRepository
     */
    private $districtRepo;

    public function __construct(ProvinceRepository $provinceRepo, DistrictRepository $districtRepo)
    {
        $this->provinceRepo = $provinceRepo;
        $this->districtRepo = $districtRepo;
    }

    public function provinces()
    {
        return $this->provinceRepo->all();
    }

    public function districtOfProvince($province_id)
    {
        return $this->districtRepo->findByField('province_id', $province_id);
    }
}
