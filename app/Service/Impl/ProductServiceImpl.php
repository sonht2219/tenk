<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Exceptions\ExecuteException;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Queue\Events\ProductSaved;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\Product\ProductSearchCriteria;
use App\Service\Contract\ProductService;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductServiceImpl implements ProductService
{
    private ProductRepository $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function createProduct(User $user, ProductRequest $data): Product
    {
        $product = (new Product())->fill($data->filteredData());

        $product->slug = $this->generateSlug($data->name);
        $product->images = implode(',', $data->images);
        $product->thumbnail = $data->images[0];
        $product->status = CommonStatus::ACTIVE;
        $product->creator()->associate($user);

        $product = $this->productRepo->save($product);
        event(new ProductSaved($product, $data->will_start_session));

        return $product;
    }

    public function singleProduct($id): Product
    {
        return $this->productRepo->find($id);
    }

    public function editProduct($id, ProductRequest $data, User $user): Product
    {
        $product = $this->singleProduct($id);
        if ($product->creator_id != $user->id) {
            throw new ExecuteException(__('Không có quyền chỉnh sửa sản phẩm này.'));
        }
        if ($data->name != $product->name) {
            $product->name = $data->name;
            $product->slug = $this->generateSlug($data->name);
        }
        $product->status = $data->status ?: $product->status;
        $product->images = implode(',', $data->images);
        $product->thumbnail = $data->images[0];
        $product->price = $data->price;
        $product->original_price = $data->original_price;

        $product = $this->productRepo->save($product);
        return $product;
    }

    private function generateSlug(string $name): string {
        $slug = str_slug($name);
        return $this->productRepo->exists(compact('slug'))
            ? $slug . round(microtime(true))
            : $slug;
    }

    public function list($limit, $search, $status): LengthAwarePaginator
    {
        if ($search)
            $this->productRepo->pushCriteria(new ProductSearchCriteria($search));

        if ($status)
            $this->productRepo->pushCriteria(new HasStatusCriteria($status));

        return $this->productRepo->paginate($limit);
    }

    public function delete($id): Product
    {
        $product = $this->singleProduct($id);

        $product->status = CommonStatus::INACTIVE;
        return $this->productRepo->save($product);
    }

    public function countProductsByStatus($status)
    {
        if ($status)
            $this->productRepo->pushCriteria(new HasStatusCriteria($status));

        return $this->productRepo->count();
    }

    public function triggerUseBot($id): Product
    {
        $product = $this->singleProduct($id);
        $product->use_bot = !$product->use_bot;
        return $this->productRepo->save($product);
    }
}
