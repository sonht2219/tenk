<?php


namespace HoangDo\Authorization\Dto;


use HoangDo\Authorization\Model\Policy;
use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Helper\Constant;

class PolicyDto
{
    public function __construct(Policy $policy)
    {
        $this->id = $policy->id;
        $this->name = $policy->name;
        $this->created_at = $policy->created_at->format(Constant::GLOBAL_TIME_FORMAT);
        $this->updated_at = $policy->updated_at->format(Constant::GLOBAL_TIME_FORMAT);
        $this->status = $policy->status;
        $this->status_title = CommonStatus::getDescription($policy->status);
        $this->roles = $policy->roles->map(fn($role) => $role->id)->toArray();
        $this->users_count = $policy->users_count;
    }
}
