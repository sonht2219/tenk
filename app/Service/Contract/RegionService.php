<?php


namespace App\Services\Contract;


interface RegionService
{
    public function provinces();
    public function districtOfProvince($province_id);
}
