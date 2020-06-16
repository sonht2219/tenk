<?php


namespace App\Service\Contract;


use App\Models\Product;

interface LotterySessionService
{
    public function create(Product $product);
}
