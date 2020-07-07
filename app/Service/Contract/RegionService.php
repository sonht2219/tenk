<?php


namespace App\Service\Contract;


interface RegionService
{
    public function provinces();
    public function districtOfProvince($province_id);
}
