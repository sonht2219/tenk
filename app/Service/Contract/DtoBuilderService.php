<?php


namespace App\Service\Contract;


use App\Models\LotterySession;
use App\Models\Product;
use App\User;

interface DtoBuilderService
{
    public function buildUserDto(User $user);
    public function buildProductDto(Product $product);
    public function buildLotterySessionDto(LotterySession $session);
}
