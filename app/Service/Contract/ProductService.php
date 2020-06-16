<?php


namespace App\Service\Contract;


use App\Exceptions\ExecuteException;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ProductService
{
    /**
     * @param User $user
     * @param ProductRequest $data
     * @return Product
     */
    public function createProduct(User $user, ProductRequest $data): Product;

    /**
     * @param $id
     * @return Product
     * @throws ModelNotFoundException
     */
    public function singleProduct($id): Product;

    /**
     * @param $id
     * @param ProductRequest $data
     * @param User $user
     * @return Product
     * @throws ModelNotFoundException
     * @throws ExecuteException
     */
    public function editProduct($id, ProductRequest $data, User $user): Product;
}
