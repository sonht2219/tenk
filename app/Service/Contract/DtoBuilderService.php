<?php


namespace App\Service\Contract;


use App\Models\Product;
use App\User;

interface DtoBuilderService
{
    public function buildUserDto(User $user);
    public function buildProductDto(Product $product);
}
